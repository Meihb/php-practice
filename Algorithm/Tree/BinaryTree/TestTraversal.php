<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/12
 * Time: 14:04
 */

namespace Algorithm\Tree;
include_once "./BinaryTree.php";


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

$binaryTree = new BinaryTree($F);
$F->addLeftChild($C);
$F->addRightChild($E);
$C->addLeftChild($A);
$C->addRightChild($D);
$D->addLeftChild($B);
$E->addLeftChild($H);
$E->addRightChild($G);
$G->addLeftChild($M);

echo "先序遍历 递归<br>";
echo implode(',', $binaryTree->Preorder_Traversal($binaryTree->root)) . "<br>";
echo "先序遍历 迭代<br>";
echo implode(',', $binaryTree->Preorder_Traversal_Iteration($binaryTree->root)) . "<br>";
echo "中序遍历 递归<br>";
echo implode(',', $binaryTree->Inorder_Traversal($binaryTree->root)) . "<br>";
echo "中序遍历 迭代<br>";
echo implode(',', $binaryTree->Inorder_Traversal_Iteration($binaryTree->root)) . "<br>";
echo "后序遍历 递归<br>";
echo implode(',', $binaryTree->Postorder_Traversal($binaryTree->root)) . "<br>";
echo "后序遍历 迭代<br>";
echo implode(',', $binaryTree->Postorder_Traversal_Iteration_v1($binaryTree->root)) . "<br>";
echo "层序遍历 迭代<br>";
echo implode(',', $binaryTree->Levelorder_Traversal($binaryTree->root)) . "<br>";

echo "插入<br>";
$binaryTree->Insert('I', $binaryTree->root);
echo implode(',',$binaryTree->Preorder_Traversal($binaryTree->root)) . "<br>";
echo implode(',',$binaryTree->Inorder_Traversal($binaryTree->root)) . "<br>";