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

function HeapSort()
{

}

function HeapBuild array $H)
{
    $length = count($H);
    for ($i = 0; $i < $length / 2; $i++) {

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
        if ($child + 1 < $length && $H[$child] < $H[$child + 1]) {//存在右子,且左子小于右子;需找到比当前待调整节点的子节点位置
            $child++;
        }
        if ($H[$child] > $H[$s]) {//较大的子节点大于父节点
            $H[$s] = $H[$child];//较大子节点和其父节点对换
            $H[$child] = $tmp;
            $s = $child;//当前层次堆处理完毕,设置被替换的子节点为新的堆顶位置
            $child = 2 * $s + 1;

        }
        print_list($H, count($H), $child);

    }
}