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
        if (!$node) {
            return black;
        } else {
            return $node->color;
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

    public function Insert_v2($node, $element)
    {
        $parent = null;//父节点
        while (!$node) {
            $parent = $node;
            if ($element > $node->data) {
                $node = $node->right;
            } elseif ($element < $node->data) {
                $node = $node->left;
            } else {
                die('不可插入等值节点');
            }
        }
        $node = new RBNode($element);
        $node->parent = $parent;
        if (!$parent) {//插入的是根节点
            $this->root = $node;
            $this->root->color = black;//根节点置为黑色
        } else {
            if ($node->data < $parent->data) {
                $parent->left = $node;
            } else {
                $parent->right = $node;
            }

            //修正
            while ($parent && $parent->color == red) {
                $grandparent = $parent->parent;

                if ($grandparent->left == $parent) {

                } else {//($grandparent->right == $parent

                }
            }
        }


    }
}