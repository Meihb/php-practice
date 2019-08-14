<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/14
 * Time: 13:34
 */

const red = "red";
const black = "black";

class RBNode
{
    public $data;
    public $color;
    public $left;
    public $right;
    public $parent;

    public function __construct($element)
    {
        $this->data = $element;
        $this->color = red;
        $this->left = null;
        $this->right = null;
        $this->parent = null;
    }
}

class MyRBT
{
    public $root;
    public $isDebug;


    /**
     * @param RBNode $node
     * @return RBNode
     */
    public function leftleftRotation(RBNode $node): RBNode
    {
//        $parent = $node->parent;
//        $childPos = $node->parent->left == $node;
        $childNode = $node->left;
        $node->left = $childNode->right;
        $childNode->right = $node;


        return $childNode;
    }

    /**
     * @param RBNode $node
     * @return RBNode
     */
    public function rightrightRotation(RBNode $node): RBNode
    {
        $childNode = $node->right;
        $node->right = $childNode->left;
        $childNode->left = $node;
        return $childNode;
    }

    /**
     * @param RBNode $node
     * @return RBNode
     */
    public function leftrightRotation(RBNode $node): RBNode
    {
        $node->left = $this->rightrightRotation($node->left);
        $node = $this->leftleftRotation($node);
        return $node;
    }

    /**
     * @param RBNode $node
     * @return RBNode
     */
    public function rightleftRotation(RBNode $node): RBNode
    {
        $node->right = $this->leftleftRotation($node->right);
        $node = $this->rightrightRotation($node);
        return $node;
    }


    public function Insert_v1($node, $element, &$resultNode)
    {
        if (!$node) {
            $node = new RBNode($element);
            $resultNode = $node;
        }
        if ($element > $node->data) {
            $node->right = $this->Insert_v1($node->right, $element, $resultNode);
            $node->right->parent = $node;
        } elseif ($element < $node) {
            $node->left = $this->Insert_v1($node->left, $element, $resultNode);
            $node->left->parent = $node;
        } else {
            echo '不能插入相同的数值';
        }
        return $node;

    }

    /**
     * @param $node
     * @return string
     */
    public function getColor($node)
    {
        if (is_null($node)) {
            return black;
        } else {
            return $node->color;
        }
    }

    /**
     * @param $node
     * @param $color
     */
    public function setColor($node, $color)
    {
        if (!is_null($node)) {
            $node->color = $color;
        }
    }

    public function debug(string $str)
    {
        if ($this->isDebug) {
            echo $str;
        } else {
            return;
        }
    }

    public function InsertFixUp($node)
    {
        /*
         * 查找父节点和叔叔节点的颜色
         */
        $parent = $node->parent;
        $grandp = $parent ? $parent->parent : null;
        $uncle = $grandp ? $parent == $grandp->left ? $grandp->right : $grandp->left : null;

        if ($parent->color == black) {//父节点为黑,无需处理
            $this->debug("parent color is black,need nothing to do <br>\r\n");
        } else {

        }
    }

    public function swapColor(&$node1, &$node2)
    {
        $tmp = $this->getColor($node1);
        $this->setColor($node1, $this->getColor($node2));
        $this->setColor($node2, $tmp);
    }

    public function Insert_v2($current, $element)
    {
        $parent = null;//父节点
        while (!$current) {
            $parent = $current;
            if ($element > $current->data) {
                $current = $current->right;
            } elseif ($element < $current->data) {
                $current = $current->left;
            } else {
                die('不可插入等值节点');
            }
        }
        $current = new RBNode($element);
        $current->parent = $parent;
        if (!$parent) {//插入的是根节点
            $this->root = $current;
            $this->root->color = black;//根节点置为黑色
        } else {
            if ($current->data < $parent->data) {
                $parent->left = $current;
            } else {
                $parent->right = $current;
            }

            //修正
            while ($parent && $parent->color == red) {//当且仅当父节点不为空(当前节点非根节点)且颜色为红色时需要处理
                $grandparent = $parent->parent;//祖父节点

                if ($grandparent->left == $parent) {//父节点是左子
                    $uncle = $grandparent->right;
                    if ($this->getColor($uncle) == red) {//叔叔节点为红色,祖父节点设为红色,父叔节点为黑色,指针指向祖父节点
                        $this->setColor($uncle, black);
                        $this->setColor($parent, black);
                        $this->setColor($grandparent, red);

                        $current = $grandparent;
                        $parent = $current->parent;//指针移动至祖节点
                    } else {//叔叔节点为黑色

                        if ($current == $parent->right) {
                            // rr旋转
                            $parent = $this->rightrightRotation($parent);
                            $grandparent->left = $parent;
                        }//再执行一次ll旋转
                        $this->swapColor($parent, $grandparent);
                        $pos = $grandparent->left == $grandparent;
                        $grandparent = $this->leftleftRotation($grandparent);
                    }

                } else {//($grandparent->right == $parent 父节点是右子 或者祖父节点为空

                }
            }
        }


    }
}