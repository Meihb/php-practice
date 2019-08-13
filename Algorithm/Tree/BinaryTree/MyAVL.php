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

    public function Delete($node, $element): TreeNode
    {
        if (!$node) {
            return null;
        }
        if ($element > $node->data) {
            $node->right = $this->Delete($node->right, $element);
            if ($this->height($node->left) - $this->height($node->right) == 2) {//节点减少在右子,右子高度减少,相当于左子insert 高度增加，因此破坏平衡的节点肯定在左子树上
                $pnode = $node->left;//获取左子树
                if ($this->height($pnode->left) > $this->height($pnode->right)) {//对左子树的左右字数高度比较,查看哪一个子树的高度较大,则破坏节点在哪里
                    //破坏节点在左子树的左子树上,则ll旋转
                    $node = $this->leftleftRotation($node);
                } else {
                    //破坏节点在左子的右子上,lr旋转
                    $node = $this->leftrightRotation($node);
                }
            }

        } elseif ($element < $node->data) {
            $node->left = $this->Delete($node->left, $element);
            if ($this->height($node->right) - $this->height($node->left) == 2) {
                $pnode = $node->right;//获取右子树
                if ($this->height($pnode->left) > $this->height($pnode->right)) {//对右子树的左右字数高度比较,查看哪一个子树的高度较大,则破坏节点在哪里
                    //破坏节点在右子树的左子树上,则rl旋转
                    $node = $this->rightleftRotation($node);
                } else {
                    //破坏节点在右子的右子上,lr旋转
                    $node = $this->rightrightRotation($node);
                }
            }
        } else {
            //此节点即为 需删除节点
            //与bst一样,主要看此节点是叶节点、单子节点、双子节点
            //区别是,双子节点是,不在任意左子树最大或右子数最小,而是取高度低的
            if ($node->left && $node->right) {
                if ($this->height($node->left) >= $this->height($node->right)) {//找左子树的最大值
                    $pnode = $node->left;
                    while ($pnode->right) {
                        $pnode = $pnode->right;
                    }
                    $node->data = $pnode->data;
                    $node->left = $this->Delete($node->left, $pnode->data);
                } else {//删除右子数的最小值
                    $pnode = $node->right;
                    while ($pnode->left) {
                        $pnode = $pnode->left;
                    }
                    $node->data = $pnode->data;
                    $node->right = $this->Delete($node->right, $pnode->data);
                }
            } else {
                $node = $node->left ? $node->left : $node->right;
            }

        }
        $node->height = $this->max($this->height($node->left), $this->height($node->right)) + 1;
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
$avl->isDebug = false;
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

$avl->isDebug = true;


