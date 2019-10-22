<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/30
 * Time: 10:54
 */

include_once "../common.php";

/**
 * 稳定 O(N^2)
 * 核心在于 插入,即把之前的队列当成已经排序好的,将当前的元素 插入 到已经排序号的队列中
 * @param array $a
 */
function StraightInsertionSort(array $a)
{
    print_list($a, count($a), 0);
    $len = count($a);
    for ($i = 1; $i < $len; $i++) {//从第二个数字开始排序,认定前面的数列已经排序完成
        if ($a[$i] < $a[$i - 1]) {//需要重新插入前列
            $guard = $a[$i];//复制为哨兵,即存储待排序元素
//            $a[$i] = $a[$i - 1];//前值后退
            $j = $i - 1;
            while ($guard < $a[$j] && $j >= 0) {//每次比较,依然比前值小,则前值后退
                $a[$j + 1] = $a[$j];
                $j--;
            }
            $a[$j + 1] = $guard;
        }

        print_list($a, count($a), $i);
    }

}

StraightInsertionSort($list_todo);

