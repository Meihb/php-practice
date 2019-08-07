<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/7
 * Time: 14:09
 */

namespace Algorithm\Tree;


class BinaryTreeNode
{
    public $data = null;
    public $lChild = null;
    public $rChild = null;

    public function __construct(String $data)
    {
        $this->data = $data;
    }

    public function addLeftChild(BinaryTreeNode $binaryTreeNode)
    {
        $this->lChild = $binaryTreeNode;
    }

    public function addRightChild(BinaryTreeNode $binaryTreeNode)
    {
        $this->rChild = $binaryTreeNode;
    }
}

class BinaryTreee
{
    public $root = null;

    public function __construct(BinaryTreeNode $binaryTreeNode)
    {
        $this->root = $binaryTreeNode;
    }


    //先序遍历
    public function Preorder_Traversal(BinaryTreeNode $binaryTreeNode)
    {
        echo $binaryTreeNode->data;
        if (!empty($binaryTreeNode->lChild)) $this->Preorder_Traversal($binaryTreeNode->lChild);
        if (!empty($binaryTreeNode->rChild)) $this->Preorder_Traversal($binaryTreeNode->rChild);
    }

    //中序遍历
    public function Inorder_Traversal(BinaryTreeNode $binaryTreeNode)
    {

        if (!empty($binaryTreeNode->lChild)) $this->Inorder_Traversal($binaryTreeNode->lChild);
        echo $binaryTreeNode->data;
        if (!empty($binaryTreeNode->rChild)) $this->Inorder_Traversal($binaryTreeNode->rChild);

    }

    //后序遍历
    public function Postorder_Traversal(BinaryTreeNode $binaryTreeNode)
    {
        if (!empty($binaryTreeNode->lChild)) $this->Postorder_Traversal($binaryTreeNode->lChild);
        if (!empty($binaryTreeNode->rChild)) $this->Postorder_Traversal($binaryTreeNode->rChild);
        echo $binaryTreeNode->data;

    }




}

//测试
$A = new BinaryTreeNode("A");
$B = new BinaryTreeNode("B");
$C = new BinaryTreeNode("C");
$D = new BinaryTreeNode("D");
$E = new BinaryTreeNode("E");
$F = new BinaryTreeNode("F");
$G = new BinaryTreeNode("G");
$H = new BinaryTreeNode("H");
$M = new BinaryTreeNode("M");

$binaryTree = new BinaryTreee($F);
$F->addLeftChild($C);
$F->addRightChild($E);
$C->addLeftChild($A);
$C->addRightChild($D);
$D->addLeftChild($B);
$E->addLeftChild($H);
$E->addRightChild($G);
$G->addLeftChild($M);


$binaryTree->Preorder_Traversal($binaryTree->root);echo "<br>";
$binaryTree->Inorder_Traversal($binaryTree->root);echo "<br>";
$binaryTree->Postorder_Traversal($binaryTree->root);echo "<br>";