<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/12
 * Time: 14:04
 */

namespace Algorithm\Tree;
require_once "./BinaryTree.php";

$binaryTree = new BinaryTree(new BinaryTreeNode("Jan"));

$binaryTree->Insert("Feb", $binaryTree->root);
$binaryTree->Insert("Mar", $binaryTree->root);
$binaryTree->Insert("Apr", $binaryTree->root);
$binaryTree->Insert("May", $binaryTree->root);
$binaryTree->Insert("Jun", $binaryTree->root);
$binaryTree->Insert("July", $binaryTree->root);
$binaryTree->Insert("Aug", $binaryTree->root);
$binaryTree->Insert("Sep", $binaryTree->root);
$binaryTree->Insert("Oct", $binaryTree->root);
$binaryTree->Insert("Nov", $binaryTree->root);
$binaryTree->Insert("Dec", $binaryTree->root);

echo implode(',', $binaryTree->Preorder_Traversal($binaryTree->root)) . "<br>";
echo implode(',', $binaryTree->Inorder_Traversal($binaryTree->root)) . "<br>";