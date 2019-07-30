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

function HeapBuild()
{

}

/**
 * 已知堆H[s....m]除了H[s]外均满足堆的定义
 * @param array $a 待调整的堆
 * @param int $s 待调整的元素位置
 * @param int $len 数组长度
 */
function HeapAdjust(array $H, $s, $len)
{
    $tmp = $H[$s];
    $child_loc = 2 * $s + 1;

    while ($child_loc < $len) {

    }
}