<?php

namespace Algorithm\TreeSearch;
/*
 * 广度优先 就是层级遍历
 * 实现方法是把节点氛围 三类 分别为:待解除、已接触、已完结
 */

class TreeNode
{
    public $data = null;
    public $children = [];

    public function __construct(string $data = null)
    {
        $this->data = $data;
    }

    public function addChildren(TreeNode $treeNode)
    {
        $this->children[] = $treeNode;
    }
}

class Tree
{
    public $root = null;

    public function __construct(TreeNode $treeNode)
    {
        $this->root = $treeNode;
    }

    /**
     * @param TreeNode $node
     * @return \SplQueue
     */
    public function BFS(TreeNode $node): \SplQueue
    {
        $queue = new \SplQueue();
        $visited = new \SplQueue();

        $queue->enqueue($node);

        while (!$queue->isEmpty()) {
            $current = $queue->dequeue();
            $visited->enqueue($current);

            foreach ($current->children as $children) {
                $queue->enqueue($children);
            }
        }

        return $visited;
    }
}

//测试
$A = new TreeNode("8");
$B = new TreeNode("3");
$C = new TreeNode("10");
$D = new TreeNode("1");
$E = new TreeNode("6");
$F = new TreeNode("14");
$G = new TreeNode("4");
$H = new TreeNode("7");
$M = new TreeNode("13");

$tree = new Tree($A);
$A->addChildren($B);
$A->addChildren($C);
$B->addChildren($D);
$B->addChildren($E);
$C->addChildren($F);
$E->addChildren($G);
$E->addChildren($H);
$F->addChildren($M);

$result = ($tree->BFS($tree->root));

var_dump($result);
//foreach ($result as $value) {
//    echo $value . "<br>";
//}