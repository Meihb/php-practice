<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/1
 * Time: 15:36
 */

require_once "../common.php";
/*
 * 冒泡是典型的交换排序
 * 在要排序的一组数中，对当前还未排好序的范围内的全部数，自上而下对相邻的两个数依次进行比较和调整，让较大的数往下沉，较小的往上冒。
 * 即：每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换
 */
function BubbleSort(array &$arr)
{
    $len = count($arr);
    for ($i = 0; $i < $len - 1; $i++) {
        print_list($arr, $len, -$i);
        for ($j = 1; $j < $len - $i; $j++) {
            if ($arr[$j] < $arr[$j - 1]) {//下值小于上值，对调
                $temp = $arr[$j];
                $arr[$j] = $arr[$j - 1];
                $arr[$j - 1] = $temp;
            }

            print_list($arr, $len, $j);
        }
    }
}


BubbleSort($list_todo);