<?php
/**
 * Created by PhpStorm.
 * User: 12538
 * Date: 2019-8-7
 * Time: 21:06
 */

namespace Algorithm\TreeSearch;


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
    public $visited;

    public function __construct(TreeNode $treeNode)
    {
        $this->root = $treeNode;
        $this->visited = new \SplQueue();
    }

    /**
     * 宗旨是把首次访问的进入边缘列,下次在访问时获取子列
     * @param TreeNode $node
     * @return \SplQueue
     */
    public function BFS(TreeNode $node): \SplQueue
    {
        $queue = new \SplQueue();//边缘列,即当前数据被访问到了,但还未向下访问
        $visited = new \SplQueue();//结果列

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

    /**
     * 队列方法 递归
     * @param TreeNode $treeNode
     * @return \SplQueue
     */
    public function DFS(TreeNode $treeNode): \SplQueue
    {
        $this->visited->enqueue($treeNode->data);

        if ($treeNode->children) {
            foreach ($treeNode->children as $child) {
                $this->DFS($child);
            }
        }
        return $this->visited;
    }

    /**
     * 栈方法 迭代
     * @param TreeNode $node
     * @return \SplQueue
     */
    public function DFSSupportStack(TreeNode $node): \SplQueue
    {
        $stack = new \SplStack();
        $visited = new \SplQueue();

        $stack->push($node);

        while (!$stack->isEmpty()) {
            $current = $stack->pop();
            $visited->enqueue($current);

            foreach ($current->children as $child) {
                $stack->push($child);
            }
        }

        return $visited;
    }

}
