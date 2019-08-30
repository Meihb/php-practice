<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/30
 * Time: 10:31
 */

class TreeNode
{
    public $data = null;
    public $lChild = null;
    public $rChild = null;
    public $isFirst = null;

    public function __construct(String $data)
    {
        $this->data = $data;
    }

    public function addLeftChild(TreeNode $binaryTreeNode)
    {
        $this->lChild = $binaryTreeNode;
    }

    public function addRightChild(TreeNode $binaryTreeNode)
    {
        $this->rChild = $binaryTreeNode;
    }
}

class HaffMan
{

}