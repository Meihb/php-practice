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
 */

function HeapSort(array $H)
{
    //创建堆
    print_list($H, count($H), -1);
    HeapBuild($H);

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
    $last_parent_has_child_key = floor(($length - 2) / 2);//最后一个拥有子节点的父节点位置,因为最后一个节点偏移为len-1
    for ($i = $last_parent_has_child_key; $i >= 0; $i--) {
        HeapAdjust($H, $i, $length);
    }
}

/**
 * 已知堆H[s....m]除了H[s]外均满足堆的定义
 * @param array $a 待调整的堆,这里讨论的成为大顶堆,即从大到小排
 * @param int $s 待调整的元素位置
 * @param int $len 数组长度
 */
function HeapAdjust(array &$H, $s, $length)
{
    $tmp = $H[$s];
    $child = 2 * $s + 1;//左子偏移量,为啥不是2$s呢，因为从0开始计数的啊

    while ($child < $length) {//数组覆盖到左子范围

        echo '当前处理' . $s . "节点:{$H[$s]}" . '为父节点的小堆', "<br>";
        if ($child + 1 < $length && $H[$child] < $H[$child + 1]) {//存在右子,且左子小于右子;需找到比当前待调整节点的子节点位置
            $child++;
        }
        if ($H[$child] > $H[$s]) {//较大的子节点大于父节点
            $H[$s] = $H[$child];//较大子节点和其父节点对换
            $H[$child] = $tmp;
            $s = $child;//当前层次堆处理完毕,设置被替换的子节点为新的堆顶位置
            $child = 2 * $s + 1;
            print_list($H, count($H), $child);
        } else {//如果此堆顶部已经满足排序,那么就无需继续处理子节点的堆了,因为我们本身就从子往父节点处理的,
            print_list($H, count($H), $child);
            break;
        }


    }
}

HeapSort($list_todo);