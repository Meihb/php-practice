<?php

/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/13
 * Time: 10:50
 */

namespace Algorithm\Tree;
class TreeNode
{
    public $data;
    public $left;
    public $right;
    public $height;

    public function __construct($element)
    {
        $this->data = $element;
        $this->left = null;
        $this->right = null;
        $this->height = 1;
    }

}

class AVL
{
    public $root;
    public $isDebug = true;

    public function __construct($element)
    {
        $this->root = new TreeNode($element);
    }

    public function debug(string $str)
    {
        if ($this->isDebug) {
            echo $str;
        } else {
            return;
        }
    }

    private function height($node)
    {
        if (is_null($node)) {
            return 0;
        } else {
            return $node->height;
        }
    }

    private function max(int $x, int $y)
    {
        return $x > $y ? $x : $y;
    }

    /**
     * LL旋转 左子的右节点换到根节点的左节点,自己画图吧
     * @param TreeNode $node
     * @return TreeNode
     */
    private function leftleftRotation(TreeNode $node): TreeNode
    {
        $pnode = $node->left;
        $node->left = $pnode->right;
        $pnode->right = $node;
        $node->height = $this->max($this->height($node->left), $this->height($node->right)) + 1;
        $pnode->height = $this->max($node->height, $this->height($pnode->left)) + 1;
        return $pnode;
    }

    /**
     * @param TreeNode $node
     * @return TreeNode
     */
    private function rightrightRotation(TreeNode $node): TreeNode
    {
        $pnode = $node->right;
        $node->right = $pnode->left;
        $pnode->left = $node;
        $node->height = $this->max($this->height($node->left), $this->height($node->right)) + 1;
        $pnode->height = $this->max($node->height, $this->height($pnode->right)) + 1;
        return $pnode;
    }

    /**
     * @param TreeNode $node
     * @return TreeNode
     */
    private function leftrightRotation(TreeNode $node): TreeNode
    {

        $node->left = $this->rightrightRotation($node->left);
        return $this->leftleftRotation($node);
    }

    /**
     * @param TreeNode $node
     * @return TreeNode
     */
    private function rightleftRotation(TreeNode $node): TreeNode
    {
        $node->right = $this->leftleftRotation($node->right);
        $node = $this->rightrightRotation($node);
        return $node;
    }


    /**
     * @param TreeNode $node
     * @param $element
     * @return TreeNode
     */
    public function Insert($node, $element)
    {
        if (!$node) {//该节点未赋值,当添加在此
            $node = new TreeNode($element);
            $this->debug('return node:' . print_r($node, true) . '<br>\r\n');
            return $node;
        }
        $this->debug('facing ' . $node->data . ',INSERT INTO ' . $element . "<br>\r\n");
        if ($node->data == $element) {
            echo('无法插入等值');

        } elseif ($element > $node->data) {//放置于右子树
            $this->debug('turn right when coming to ' . $node->data . "<br>\r\n");
            $node->right = $this->Insert($node->right, $element);
            if ($this->height($node->right) - $this->height($node->left) == 2) {//右子树数高过左子树高度2,进行调整
                if ($element > $node->right->data) {//rr旋转
                    $this->debug('rr rotation:' . $node->data . "<br>\r\n");
                    $node = $this->rightrightRotation($node);
                } else {//rl旋转
                    $this->debug('rl rotation:' . $node->data . "<br>\r\n");
                    $node = $this->rightleftRotation($node);
                }
            } else {
                $this->debug("need no roration for {$node->data}" . "<br>\r\n");
            }
        } else {//放置于左子树
            $this->debug('turn left when coming to ' . $node->data . "<br>\r\n");
            $node->left = $this->Insert($node->left, $element);
            if ($this->height($node->left) - $this->height($node->right) == 2) {//右子树数高过左子树高度2,进行调整
                if ($element > $node->left->data) {//lr旋转
                    $this->debug('lr rotation:' . $node->data . "<br>\r\n");
                    $node = $this->leftrightRotation($node);
                } else {//ll旋转
                    $this->debug('ll rotation:' . $node->data . "<br>\r\n");
                    $node = $this->leftleftRotation($node);
                }

            } else {
                $this->debug("need no roration for {$node->data}" . "<br>\r\n");
            }

        }
        $node->height = $this->max($this->height($node->left), $this->height($node->right)) + 1;//更新节点高度
        $this->debug('return node:' . print_r($node, true) . '<br>\r\n');
        return $node;
    }

    public function preOrder($treeNode, &$visited = [])
    {
        if ($treeNode) {
//            $this->debug('  node:' . print_r($treeNode, true) . '<br>\r\n');
            $visited[] = $treeNode->data;
            $this->preOrder($treeNode->left, $visited);
            $this->preOrder($treeNode->right, $visited);
        }
        return $visited;
    }


    public function inOrder($treeNode, &$visited = [])
    {
        if ($treeNode) {
//            $this->debug('  node:' . print_r($treeNode, true) . '<br>\r\n');
            $this->inOrder($treeNode->left, $visited);
            $visited[] = $treeNode->data;
            $this->inOrder($treeNode->right, $visited);
        }
        return $visited;
    }
}

$arr = [3, 88, 58, 47, 2, 37, 51, 99, 73, 93];
$avl = new AVL(3);
$avl->isDebug = true;
/*
$avl->root = $avl->Insert($avl->root, 88);
echo '先序:' . implode(',', $avl->preOrder($avl->root)) . "<br>\r\n";
echo '中序:' . implode(',', $avl->inOrder($avl->root)) . "<br>\r\n";

$avl->root = $avl->Insert($avl->root, 58);
echo '先序:' . implode(',', $avl->preOrder($avl->root)) . "<br>\r\n";
echo '中序:' . implode(',', $avl->inOrder($avl->root)) . "<br>\r\n";

$avl->Insert($avl->root, 47);
echo '先序:' . implode(',', $avl->preOrder($avl->root)) . "<br>\r\n";
echo '中序:' . implode(',', $avl->inOrder($avl->root)) . "<br>\r\n";
*/

for ($i = 1; $i < count($arr); $i++) {
    $avl->root = $avl->Insert($avl->root, $arr[$i]);//次root赋值是关键
    echo '先序:' . implode(',', $avl->preOrder($avl->root)) . "<br>\r\n";
    echo '中序:' . implode(',', $avl->inOrder($avl->root)) . "<br>\r\n";
}



