<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/7
 * Time: 14:09
 */

namespace Algorithm\Tree;
class TreeNode
{
    public $data = null;
    public $children = [];

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function addChildren(TreeNode $treeNode)
    {
        $this->children[] = $treeNode;
    }
}

/*
 * 层次与高度不同,层次从根节点到当前节点,由零开始;高度有当前节点到最下后裔;
 */

class Tree
{
    public $root = null;

    public function __construct(TreeNode $treeNode)
    {
        $this->root = $treeNode;
    }

    //遍历节点,这个是先根遍历 吧
    public function traverse(TreeNode $treeNode, int $level = 0)
    {
        if (!$treeNode) return;
        echo str_repeat('-', $level) . $treeNode->data . "</br>";
        foreach ($treeNode->children as $child) {
            $this->traverse($child, $level + 1);
        }
    }

}

//测试
$ceo = new TreeNode('ceo');
$cfo = new TreeNode('cfo');
$cto = new TreeNode('cto');
$cmo = new TreeNode('cmo');
$coo = new TreeNode('coo');

$tree = new Tree($ceo);
$ceo->addChildren($cfo);
$ceo->addChildren($cto);
$ceo->addChildren($cmo);
$ceo->addChildren($coo);

$seniorArchitect = new TreeNode('Senior Architect');
$softwareEngineer = new TreeNode('Software Engineer');
$userInterfaceDesigner = new TreeNode("userInterface Designer");
$qualityAssuranceEngineer = new TreeNode("qualityAssurance Engineer");


$cto->addChildren($seniorArchitect);
$seniorArchitect->addChildren($softwareEngineer);

$cto->addChildren($userInterfaceDesigner);
$cto->addChildren($qualityAssuranceEngineer);

$tree->traverse($tree->root);
