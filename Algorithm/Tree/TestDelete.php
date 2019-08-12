<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/12
 * Time: 14:04
 */

namespace Algorithm\Tree;
require_once "./BinaryTree.php";
require_once "./BinaryTreeImage.php";
$binaryTree = new BinaryTree(new BinaryTreeNode(30));

$binaryTree->Insert(15, $binaryTree->root);
$binaryTree->Insert(41, $binaryTree->root);
$binaryTree->Insert(50, $binaryTree->root);
$binaryTree->Insert(33, $binaryTree->root);
$binaryTree->Insert(35, $binaryTree->root);
$binaryTree->Insert(34, $binaryTree->root);

echo '先序' . implode(',', $binaryTree->Preorder_Traversal($binaryTree->root)) . "<br>";
echo '中序' . implode(',', $binaryTree->Inorder_Traversal($binaryTree->root)) . "<br>";

//$binaryTree->DeleteRightWing(41,$binaryTree->root);
//echo '先序' . implode(',', $binaryTree->Preorder_Traversal($binaryTree->root)) . "<br>";
//echo '中序' . implode(',', $binaryTree->Inorder_Traversal($binaryTree->root)) . "<br>";


$binaryTree->DeleteLeftWing(41,$binaryTree->root);
echo '先序' . implode(',', $binaryTree->Preorder_Traversal($binaryTree->root)) . "<br>";
echo '中序' . implode(',', $binaryTree->Inorder_Traversal($binaryTree->root)) . "<br>";