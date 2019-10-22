<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/30
 * Time: 15:49
 */
require "../common.php";

/*
 * Ki<=K2i;Ki<K2i+1
 * 根据排序过得树进行排序,主要是创建堆,推出堆顶元素,以及重建堆
 *
 * 若要建成小顶堆,则每次调整取出的为最大值(因为每次取出堆顶pop到堆尾)
 */

function HeapSort(array $H)
{
    //创建堆
    print_list($H, count($H), -1);
    HeapBuild($H);
    $length = count($H);
    //从最后一个元素进行调整
    for ($i = count($H) - 1; $i > 0; $i--) {
        echo "交换节点{$i}元素和堆顶" . "<br>";

        //交换堆顶元素和堆最后一个元素
        $temp = $H[$i];
        $H[$i] = $H[0];
        $H[0] = $temp;
        $length--;//取出的最值和堆尾部元素互换之后,此尾部位置元素已经确定位置
        print_list($H, count($H), -1);
        //调整堆
        HeapAdjust($H, 0, $length);
    }
}

/**
 * 将初始堆进行调整
 * 将H[0....len-1]建成堆
 * 从最后一个有子节点的位置开始从后往前(从前往后为何不能,因从上往下调整不能完全保证,因一父有两子,而一子只有一父)
 * @param array $H
 */
function HeapBuild(array &$H)
{
    $length = count($H);
    //在数组下表从零开始的基础上,找到最后一个拥有子节点的节点位置,一直leftchild =2*parent+1,则最后一个至少拥有左子的节点满足 2*parent+1>=len-1,parent>=(len-2)/2,取整即可
    $last_parent_has_child_key = floor(($length - 2) / 2);//最后一个拥有子节点的父节点位置,因为最后一个节点偏移为len-1
    for ($i = $last_parent_has_child_key; $i >= 0; $i--) {
        HeapAdjust($H, $i, $length);
    }
    //取出堆顶元素
}

/**
 * 已知堆H[s....m]除了H[s]外均满足堆的定义
 * @param array $a 待调整的堆,这里讨论的成为小顶堆,即从小到大排,那么每次向上选择的是大于父节点的较大子
 * @param int $s 待调整的元素位置
 * @param int $len 数组长度
 */
function HeapAdjust(array &$H, $s, $length)
{
    $child = 2 * $s + 1;//左子偏移量,为啥不是2$s呢，因为从0开始计数的啊

    while ($child < $length) {//数组覆盖到左子范围 len-1>=2*node+1
        $tmp = $H[$s];
        echo '当前处理' . $s . "节点:{$H[$s]}" . '为父节点的部分堆', "<br>";
        if ($child + 1 < $length && $H[$child] < $H[$child + 1]) {//存在右子,且左子小于右子;则右子为较大值
            $child += 1;
        }
        if ($H[$child] > $H[$s]) {//较小的子节点小于父节点
            $H[$s] = $H[$child];// 对换
            $H[$child] = $tmp;
            $s = $child;//当前层次堆处理完毕,设置被替换的子节点为新的堆顶位置
            $child = 2 * $s + 1;
            print_list($H, count($H), $child);
        } else {//如果此堆顶部已经满足排序,那么就无需继续处理子节点的堆了,因为替换之前堆本身是稳定的
            print_list($H, count($H), $child);
            break;
        }


    }
}

HeapSort($list_todo);

/*
 * 空间复杂度很明显,原地算法,O(1)
 * 时间复杂度相对复杂 首先 堆深度和 节点总数 n的关系,k = [logn]+1,也可以简化为lgn（底数为2,省略以简洁）
 *
 * 分为两部分计算,一个是heapBuild,另一个为heapAdjust
 * HeapBuild:
 *           从倒数第二层的最右边非叶子节点开始向前计算
 *          S=∑(i=1->k-1) 2^(i-1) * (k-i);2^i-1表示第i层的元素个数,再次我们以完全二叉树计算,(k-i)表示每个元素需要对比的次数
 *          S = 2^0*(k-1)+2^1*(k-2)+.............+2^(k-3)*(2)+2^(k-2)*1;
 *         2S =           2^1*(k-1)+2^2*(k-2)+...+2^(k-3)*(3)+2^(k-2)*2+2^(k-1)*1;
 *    2s - s = -k+1+2^1+2^2+...+2^k-3+2^k-2+2^k-1 = 2^k-k-1;将k=lg n 代入
 *          S = n-lg(n)-1 = O(n);
 * HeapAdjust:
 *          调整需要经过n-1次,从n的长度一直调整到2的长度,而每次需要调整lg(n)此
 *          S = lg2+lg3+...+lgn = lg(n!)
 *          有Stiling's Formula等一系列换算,lg(n!)和nlg(n)为同阶函数
 * 求得O(n) = O(nlgn+n) = O(lgn)
 */