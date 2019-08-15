<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/14
 * Time: 13:34
 */

const red = "red";
const black = "black";

error_reporting(E_ALL);

class RBNode
{
    public $data;
    public $color;
    public $left;
    public $right;
    public $parent;

    public function __construct($element)
    {
        $this->data = $element;
        $this->color = red;
        $this->left = null;
        $this->right = null;
        $this->parent = null;
    }
}

class MyRBT
{
    public $root;
    public $isDebug;

    public function __construct()
    {
        $this->root = null;
    }


    /**
     * @param RBNode $node
     */
    public function leftleftRotation(RBNode $root)
    {
        $L = $root->left;//左子
        //重新搭建根节点和父节点 键关系
        if (!is_null($root->parent)) {//根节点存在父节点
            $P = $root->parent;
            if ($P->left == $root) {
                $P->left = $L;
            } else {
                $P->right = $L;
            }
        } else {
            $P = null;
        }
        $L->parent = $P;

        //重新搭建 左子的右子和 node 键关系
        $L_R = $L->right;
        $L_R->parent = $root;
        $root->left = $L_R;

        //重新搭建 根节点和子节点
        $L->right = $root;
        $root->parent = $L;

        if (is_null($P)) {//若父节点为Null,则当前处理的是树的root节点
            $this->root = $L;
        }

    }

    /**
     * @param RBNode $node
     */
    public function rightrightRotation(RBNode $root)
    {
        $R = $root->right;//右子，将来的根节点
        $R_L = $R->left;//右子的左子,将来要调动到node的右边

        if (!is_null($root->parent)) {
            $P = $root->parent;
            if ($P->left == $root) {
                $P->left = $R;
            } else {
                $P->right = $R;
            }
        } else {
            $P = null;
        }
        $R->parent = $P;

        $R_L->parent = $root;
        $root->right = $R_L;

        $R->left = $root;
        $root->parent = $R;

        if (is_null($P)) {
            $this->root = $R;
        }


    }


    public function Insert_v1($node, $element, &$resultNode)
    {
        if (!$node) {
            $node = new RBNode($element);
            $resultNode = $node;
        }
        if ($element > $node->data) {
            $node->right = $this->Insert_v1($node->right, $element, $resultNode);
            $node->right->parent = $node;
        } elseif ($element < $node) {
            $node->left = $this->Insert_v1($node->left, $element, $resultNode);
            $node->left->parent = $node;
        } else {
            echo '不能插入相同的数值';
        }
        return $node;

    }

    /**
     * @param $node
     * @return string
     */
    public function getColor($node)
    {
        if (is_null($node)) {
            return black;
        } else {
            return $node->color;
        }
    }

    /**
     * @param $node
     * @param $color
     */
    public function setColor($node, $color)
    {
        if (!is_null($node)) {
            $node->color = $color;
        }
    }

    public function debug(string $str)
    {
        if ($this->isDebug) {
            echo $str;
        } else {
            return;
        }
    }

    public function preOrder($node, array &$visited = [])
    {
        if (!is_null($node)) {
            $visited[] = $node->data;
            $this->preOrder($node->left, $visited);
            $this->preOrder($node->right, $visited);
        }
        return $visited;
    }

    public function inOrder($node, array &$visited = [])
    {
        if (!is_null($node)) {
            $this->inOrder($node->left, $visited);
            $visited[] = $node->data;
            $this->inOrder($node->right, $visited);
        }
        return $visited;
    }

    public function InsertFixUp($node)
    {
        /*
         * 查找父节点和叔叔节点的颜色
         */
        $parent = $node->parent;
        $grandp = $parent ? $parent->parent : null;
        $uncle = $grandp ? $parent == $grandp->left ? $grandp->right : $grandp->left : null;

        if ($parent->color == black) {//父节点为黑,无需处理
            $this->debug("parent color is black,need nothing to do <br>\r\n");
        } else {

        }
    }

    public function swapColor($node1, $node2)
    {
        $tmp = $this->getColor($node1);
        $this->setColor($node1, $this->getColor($node2));
        $this->setColor($node2, $tmp);
    }

    public function Insert_v2($current, $element)
    {
        $this->debug("insert {$element} into  node:" . print_r($current, true) . " < br>\r\n");
        $parent = null;//父节点
        while (!is_null($current)) {
            $parent = $current;
            if ($element > $current->data) {
                $current = $current->right;
            } elseif ($element < $current->data) {
                $current = $current->left;
            } else {
                die('不可插入等值节点');
            }
        }
        $current = new RBNode($element);
        $current->parent = $parent;
        if (!$parent) {//插入的是根节点
            $this->root = $current;
            $this->root->color = black;//根节点置为黑色
            $this->debug("after inserting {$element} ,  root node became:" . print_r($current, true) . " <br>\r\n");
        } else {
            if ($current->data < $parent->data) {
                $parent->left = $current;
            } else {
                $parent->right = $current;
            }

            $this->debug("after inserting  {$element}， root node became :" . print_r($this->root, true) . " <br>\r\n");


            //修正
            while ($parent && $parent->color == red) {//当且仅当父节点不为空(当前节点非根节点)且颜色为红色时需要处理
                $grandparent = $parent->parent;//祖父节点

                $this->debug("do need fixing,grandparent node:" . print_r($grandparent, true) . " <br>\r\n");
                if ($grandparent->left == $parent) {//父节点是左子
                    $this->debug("fixing, parent is the left son    <br>\r\n");
                    $uncle = $grandparent->right;//叔叔节点

                    $this->debug("fixing, uncle is " . print_r($uncle, true) . " <br>\r\n");
                    if ($this->getColor($uncle) == red) {//叔叔节点为红色,祖父节点设为红色,父叔节点为黑色,指针指向祖父节点
                        $this->setColor($uncle, black);
                        $this->setColor($parent, black);
                        $this->setColor($grandparent, red);

                        $current = $grandparent;
                        $parent = $current->parent;//指针移动至祖节点
                    } else {//叔叔节点为黑色
                        if ($current == $parent->right) {//当前节点为右子
                            //先对父节点rr旋转
                            $this->debug("rr rotation <br>\r\n");
                            $this->rightrightRotation($parent);
                        }
                        //交换父祖颜色,执行ll旋转
                        $this->swapColor($parent, $grandparent);
                        $this->debug("ll rotation <br>\r\n");
                        $this->leftleftRotation($grandparent);

                    }
                    $this->debug("fixing {$element} change  grandparent node :" . print_r($grandparent, true) . " <br>\r\n");

                } else {//($grandparent->right == $parent 父节点是右子 或者祖父节点为空 ？为什么祖父节点不会为空呢,因为不会产生这种情况,至少到第三层才开始出现红黑失衡
                    $this->debug("fixing, parent is the right son    <br>\r\n");
                    $uncle = $grandparent->left;//叔叔节点
                    $this->debug("fixing, uncle is " . print_r($uncle, true) . " <br>\r\n");
                    $this->debug("uncle color is " . $this->getColor($uncle) . "<br>\r\n");
                    if ($this->getColor($uncle) == red) {
                        $this->setColor($uncle, black);
                        $this->setColor($parent, black);
                        $this->setColor($grandparent, red);

                        $current = $grandparent;
                        $parent = $current->parent;//指针移动至祖节点
                    } else {//叔叔节点是黑色
                        if ($current == $parent->left) {
                            $this->debug("ll rotation <br>\r\n");
                            $this->leftleftRotation($parent);
                        }
                        //交换颜色,执行rr旋转
                        $this->swapColor($grandparent, $parent);
                        $this->debug("rr rotation <br>\r\n");
                        $this->rightrightRotation($grandparent);


                    }
                    $this->debug("fixing {$element} change  grandparent node :" . print_r($grandparent, true) . " <br>\r\n");
                }
            }
            $this->setColor($this->root, black);//最终要记得把根节点颜色改为黑色

            $this->debug("root node :" . print_r($this->root, true) . " <br>\r\n");
        }


    }


    public function search($node, $element)
    {
        while (!is_null($node)) {
            if ($element > $node->data) {
                $node = $node->right;
            } elseif ($element < $node->data) {
                $node = $node->right;
            } else {
                return $node;
            }
        }

        return null;
    }

    /*
     * 被删除的节点 case 如下
     *  case 无子节点
     *      1.删除节点为红色                                                                                                  直接删除,不影响红黑树性质
     *      2.删除节点为黑色
     *              2.1 其兄弟节点无子     
     *              2.2 其兄弟节点有且仅有左子
     *              2.3 其兄弟节点有且仅有右子
     *              2.4 其兄弟节点有两子
     *                  2.4.1 兄弟节点为黑色
     *                  2.4.2 兄弟节点为红色
     *  case 有且仅有一个子节点
     *      1. 删除节点为黑色,其唯一子节点只能为红色(若为黑色那么删除节点到两子的黑色球数不用,违反红黑树第五条性质)
     *      2. 删除节点为红色,则因为性质3则唯一子节点只能为黑色,但也因此违背性质5,故不存在此情形
     *
     * case 有双子节点,转化为前两者情形
     */
    public function Delete($node, $element)
    {

    }
}

$myrbt = new MyRBT();
$myrbt->isDebug = false;

$myrbt->isDebug = true;
$arr = [30, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150];

/*
$myrbt->Insert_v2($myrbt->root, 30);
echo '先序:' . implode(',', $myrbt->preOrder($myrbt->root)) . " <br>\r\n";
echo '中序:' . implode(',', $myrbt->inOrder($myrbt->root)) . " <br>\r\n";

$myrbt->Insert_v2($myrbt->root, 50);
echo '先序:' . implode(',', $myrbt->preOrder($myrbt->root)) . " <br>\r\n";
echo '中序:' . implode(',', $myrbt->inOrder($myrbt->root)) . " <br>\r\n";
$myrbt->Insert_v2($myrbt->root, 60);
echo '先序:' . implode(',', $myrbt->preOrder($myrbt->root)) . " <br>\r\n";
echo '中序:' . implode(',', $myrbt->inOrder($myrbt->root)) . " <br>\r\n";


$myrbt->Insert_v2($myrbt->root, 70);
echo '先序:' . implode(',', $myrbt->preOrder($myrbt->root)) . " <br>\r\n";
echo '中序:' . implode(',', $myrbt->inOrder($myrbt->root)) . " <br>\r\n";
*/
for ($i = 0; $i < count($arr); $i++) {
    $myrbt->Insert_v2($myrbt->root, $arr[$i]);
    echo '先序:' . implode(',', $myrbt->preOrder($myrbt->root)) . " <br>\r\n";
    echo '中序:' . implode(',', $myrbt->inOrder($myrbt->root)) . " <br>\r\n";
}
