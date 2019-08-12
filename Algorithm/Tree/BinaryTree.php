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
    public $isFirst = null;

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

class BinaryTree
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
                $binaryTreeNode = $binaryTreeNode->lChild;//访问左子
            }
            if ($stack->count() > 0) {//
                //左子遍历结束，访问右子
                $binaryTreeNode = $stack->pop();
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
    public function Postorder_Traversal_Iteration_v1(BinaryTreeNode $binaryTreeNode): array
    {
        $visited = [];
        $stack = new \SplStack();
        $stack->setIteratorMode(\SplDoublyLinkedList::IT_MODE_LIFO | \SplDoublyLinkedList::IT_MODE_DELETE);//设置iterator mode,即 后进先出、遍历即删除
        while ($binaryTreeNode || $stack->count() > 0) {//判断条件,要么有左子,要么栈不为空
            while ($binaryTreeNode) {
                $binaryTreeNode->isFirst = true;
                $stack->push($binaryTreeNode);//入栈
                $binaryTreeNode = $binaryTreeNode->lChild;//访问左子
            }
            if ($stack->count() > 0) {
                $binaryTreeNode = $stack->pop();
                if ($binaryTreeNode->isFirst == true) {//第一次出现在栈顶,此时其左子已经遍历结束,需要遍历右子,由于是后序遍历,还不能pop出栈
                    $binaryTreeNode->isFirst = false;
                    $stack->push($binaryTreeNode);//重新入栈
                    $binaryTreeNode = $binaryTreeNode->rChild;
                } else {//第二次出现在栈顶
                    $visited[] = $binaryTreeNode->data;
                    $binaryTreeNode = null;//手动置空,令此节点退出循环
                }
            }

        }
        return $visited;
    }

    /**
     * @param BinaryTreeNode $binaryTreeNode
     * @return array
     */
    public function Levelorder_Traversal(BinaryTreeNode $binaryTreeNode): array
    {
        $visited = [];
        $queue = new \SplQueue();
        $queue->setIteratorMode(\SplQueue::IT_MODE_FIFO | \SplQueue::IT_MODE_DELETE);
        if (!$binaryTreeNode) return $visited;
        $queue->push($binaryTreeNode);//插入根节点
        while ($queue->count() > 0) {
            $btn = $queue->dequeue();//抛出一个节点
//            echo "visiting treenode {$binaryTreeNode->data}<br>";
            $visited[] = $btn->data;//访问数据
            if ($btn->lChild) $queue->enqueue($btn->lChild);
            if ($btn->rChild) $queue->enqueue($btn->rChild);
        }
        return $visited;
    }

    /**
     * @param String $element
     * @param BinaryTreeNode $binaryTreeNode
     */
    public function Insert(String $element, BinaryTreeNode &$binaryTreeNode)
    {
        if ($element > $binaryTreeNode->data) {//较根值大,则转右子树
            if ($binaryTreeNode->rChild) {//存在右子树,递归
                $this->Insert($element, $binaryTreeNode->rChild);
            } else {//不存在右子,设为右子
                $binaryTreeNode->rChild = new BinaryTreeNode($element);
            }
        } elseif ($element < $binaryTreeNode->data) {
            if ($binaryTreeNode->lChild) {
                $this->Insert($element, $binaryTreeNode->lChild);
            } else {
                $binaryTreeNode->lChild = new BinaryTreeNode($element);
            }
        } else {
            return;
        }

        return;
    }


    /**
     * 删除分三种情况
     * 删除叶节点,最简单,置为Null
     * 删除有一个子树的父节点,相对简单,把子节点提上来就是
     * 删除一个度为2的节点,比较复杂,尝试变成 删除一个子树的情形,即 找到被删节点的 左子树的最大值 或者 右子树的最小值
     *    此两种情况下,由于找到的左子树最大值或右子树最小值必然不多于一个子(左子树最大值必然在最右边,不能存在右子,同理,右子树最小值必然在最左边,不能存在左子)
     *    那么用此节点代替被删节点,在处理此节点原本位置被删除的情况,就变成第二种类型的问题
     * @param String $element
     * @param  $binaryTreeNode
     */
    public function DeleteLeftWing(String $element, &$binaryTreeNode)
    {
        if (!$binaryTreeNode) die('未查询到相关元素');

        if ($element > $binaryTreeNode->data) {
             $this->DeleteLeftWing($element, $binaryTreeNode->rChild);
        } elseif ($element < $binaryTreeNode->data) {
              $this->DeleteLeftWing($element, $binaryTreeNode->lChild);
        } else {//got it
            if ($binaryTreeNode->rChild && $binaryTreeNode->lChild) {//度2
                //在左子树查找最大值
                $maxElement = $this->findMax($binaryTreeNode->lChild);
                //用此最大值替换被删除节点
                $binaryTreeNode->data = $maxElement;
                //在左子树删除此最大值
                $this->DeleteLeftWing($maxElement, $binaryTreeNode->lChild);

            } elseif ($binaryTreeNode->lChild || $binaryTreeNode->rChild) {//度1
                $binaryTreeNode->lChild ? $binaryTreeNode = $binaryTreeNode->lChild : $binaryTreeNode = $binaryTreeNode->rChild;
            } else {//度0,叶子节点
                $binaryTreeNode->data = null;
            }

        }
    }

    public function DeleteRightWing(String $element, &$binaryTreeNode)
    {
        if (!$binaryTreeNode) die('未查询到相关元素');

        if ($element > $binaryTreeNode->data) {
            $this->DeleteRightWing($element, $binaryTreeNode->rChild);
        } elseif ($element < $binaryTreeNode->data) {
            $this->DeleteRightWing($element, $binaryTreeNode->lChild);
        } else {//got it
            if ($binaryTreeNode->rChild && $binaryTreeNode->lChild) {//度2
                //在右子树查找最小值
                $minElement = $this->findMin($binaryTreeNode->rChild);
                //用此最小值替换被删除节点
                $binaryTreeNode->data = $minElement;
                //在右子树删除此最小值
                $this->DeleteRightWing($minElement, $binaryTreeNode->rChild);

            } elseif ($binaryTreeNode->lChild || $binaryTreeNode->rChild) {//度1
                $binaryTreeNode->lChild ? $binaryTreeNode = $binaryTreeNode->lChild : $binaryTreeNode = $binaryTreeNode->rChild;
            } else {//度0,叶子节点
                $binaryTreeNode->data = null;
            }
        }
    }

    /**
     * @param BinaryTreeNode $binaryTreeNode
     * @return String
     */
    public function findMin(BinaryTreeNode $binaryTreeNode): String
    {
        $tmp = $binaryTreeNode->data;
        while ($binaryTreeNode->lChild) {
            $binaryTreeNode = $binaryTreeNode->lChild;
            $tmp = $binaryTreeNode->data;
        }
        return $tmp;
    }

    /**
     * @param BinaryTreeNode $binaryTreeNode
     * @return String
     */
    public function findMax(BinaryTreeNode $binaryTreeNode): String
    {
        $tmp = $binaryTreeNode->data;
        while ($binaryTreeNode->rChild) {
            $binaryTreeNode = $binaryTreeNode->rChild;
            $tmp = $binaryTreeNode->data;
        }
        return $tmp;
    }
}




