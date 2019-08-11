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
    public $visited = [];

    public function __construct(BinaryTreeNode $binaryTreeNode)
    {
        $this->root = $binaryTreeNode;
    }


    //先序遍历
    public function Preorder_Traversal(BinaryTreeNode $binaryTreeNode, array &$visited = []): array
    {
        $visited[] = $binaryTreeNode->data;
        if (!empty($binaryTreeNode->lChild)) $this->Preorder_Traversal($binaryTreeNode->lChild, $visited);
        if (!empty($binaryTreeNode->rChild)) $this->Preorder_Traversal($binaryTreeNode->rChild, $visited);
        return $visited;
    }

    /**
     * 先序遍历 栈迭代实现
     * 可见栈和双链表的区别就是IteratorMode改变了而已，栈的IteratorMode只能为：
     * （1）SplDoublyLinkedList::IT_MODE_LIFO | SplDoublyLinkedList::IT_MODE_KEEP （默认值,迭代后数据保存）
     * （2）SplDoublyLinkedList::IT_MODE_LIFO | SplDoublyLinkedList::IT_MODE_DELETE （迭代后数据删除）
     * @param BinaryTreeNode $binaryTreeNode
     * @param array $visited
     * @return array
     */
    public function Preorder_Traversal_Iteration(BinaryTreeNode $binaryTreeNode): array
    {
        $stack = new \SplStack();
        $stack->setIteratorMode(\SplDoublyLinkedList::IT_MODE_LIFO | \SplDoublyLinkedList::IT_MODE_DELETE);//设置
        while ($binaryTreeNode || $stack->count() > 0) {//判断条件,要么有左子,要么栈不为空
            while ($binaryTreeNode) {
//                echo "visiting treenode {$binaryTreeNode->data}<br>";
                $visited[] = $binaryTreeNode->data;//处理data
                $stack->push($binaryTreeNode);//入栈

//                echo "stack push in  {$binaryTreeNode->data},length={$stack->count()}<br>";
                $binaryTreeNode = $binaryTreeNode->lChild;//访问左子
            }
            if ($stack->count() > 0) {//
                //左子遍历结束，访问右子

                $binaryTreeNode = $stack->pop();
//                echo "stack pop out in  {$binaryTreeNode->data},length={$stack->count()}<br>";
                $binaryTreeNode = $binaryTreeNode->rChild;
            }

        }
        return $visited;
    }

    //中序遍历
    public function Inorder_Traversal(BinaryTreeNode $binaryTreeNode, array & $visited = []): array
    {
        if (!empty($binaryTreeNode->lChild)) $this->Inorder_Traversal($binaryTreeNode->lChild, $visited);
        $visited[] = $binaryTreeNode->data;
        if (!empty($binaryTreeNode->rChild)) $this->Inorder_Traversal($binaryTreeNode->rChild, $visited);
        return $visited;

    }

    /**
     * @param BinaryTreeNode $binaryTreeNode
     * @return array
     */
    public function Inorder_Traversal_Iteration(BinaryTreeNode $binaryTreeNode): array
    {
        $stack = new \SplStack();
        $stack->setIteratorMode(\SplDoublyLinkedList::IT_MODE_LIFO | \SplDoublyLinkedList::IT_MODE_DELETE);//设置
        while ($binaryTreeNode || $stack->count() > 0) {//判断条件,要么有左子,要么栈不为空
            while ($binaryTreeNode) {
//                echo "visiting treenode {$binaryTreeNode->data}<br>";
                $stack->push($binaryTreeNode);//入栈

//                echo "stack push in  {$binaryTreeNode->data},length={$stack->count()}<br>";
                $binaryTreeNode = $binaryTreeNode->lChild;//访问左子
            }
            if ($stack->count() > 0) {
                $binaryTreeNode = $stack->pop();
                //左子遍历结束，处理data,再访问右子
                $visited[] = $binaryTreeNode->data;//处理data
//                echo "stack pop out in  {$binaryTreeNode->data},length={$stack->count()}<br>";
                $binaryTreeNode = $binaryTreeNode->rChild;
            }

        }
        return $visited;
    }

    //后序遍历
    public function Postorder_Traversal(BinaryTreeNode $binaryTreeNode, array & $visited = []): array
    {
        if (!empty($binaryTreeNode->lChild)) $this->Postorder_Traversal($binaryTreeNode->lChild, $visited);
        if (!empty($binaryTreeNode->rChild)) $this->Postorder_Traversal($binaryTreeNode->rChild, $visited);
        $visited[] = $binaryTreeNode->data;
        return $visited;

    }

    /**
     * @param BinaryTreeNode $binaryTreeNode
     * @return array
     */
    public function Postorder_Traversal_Iteration(BinaryTreeNode $binaryTreeNode): array
    {
        $visited = [];
        $stack = new \SplStack();
        $stack_r = new \SplStack();
        $stack->setIteratorMode(\SplDoublyLinkedList::IT_MODE_LIFO | \SplDoublyLinkedList::IT_MODE_DELETE);//设置iterator mode,即 后进先出、遍历即删除
        $stack_r->setIteratorMode(\SplDoublyLinkedList::IT_MODE_LIFO | \SplDoublyLinkedList::IT_MODE_DELETE);//设置
        while ($binaryTreeNode || $stack->count() > 0) {//判断条件,要么有左子,要么栈不为空
            while ($binaryTreeNode) {
//                echo "visiting treenode {$binaryTreeNode->data}<br>";
                $stack->push($binaryTreeNode);//入栈

//                echo "stack push in  {$binaryTreeNode->data},length={$stack->count()}<br>";
                $binaryTreeNode = $binaryTreeNode->lChild;//访问左子
            }
            if ($stack->count() > 0) {
                $binaryTreeNode = $stack->top();
                if (!$binaryTreeNode->rChild) {//不存在右子,同时也是入栈过得,即左子也遍历结束了,则处理data
                    $visited[] = $binaryTreeNode->data;
                }
                $binaryTreeNode = $stack->pop();
//                echo "stack pop out in  {$binaryTreeNode->data},length={$stack->count()}<br>";
                $binaryTreeNode = $binaryTreeNode->rChild;
            }

        }
        return $visited;
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
echo implode(',', $binaryTree->Postorder_Traversal_Iteration($binaryTree->root)) . "<br>";
