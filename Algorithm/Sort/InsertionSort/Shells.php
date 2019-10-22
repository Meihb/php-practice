<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/30
 * Time: 11:42
 */
include_once "../common.php";

/**
 * 不稳定排序
 * @param array $a
 */
function shellsSort(array $a)
{
    $len = count($a);
    $dec = floor($len / 2);//增量

    print_list($a, $len, 0);
    while ($dec >= 1) {
        print_list($a, $len, $dec);
        shellStraightInsertionSort($a, $len, $dec);
        $dec = floor($dec / 2);
    }
}

/**
 * @param array $a
 * @param $n  int 长度
 * @param  $dec int <p>增量</p>
 */
function shellStraightInsertionSort(array &$a, $n, $dec)
{
    //对下标相差$dec的一组数据进行直接插入排序
    for ($i = $dec; $i < $n; $i++) {//如同直接插入排序一样，默认每组第一个数是排序好的,故 从第增量个数开始
        if ($a[$i] < $a[$i - $dec]) {
            $guard = $a[$i];
            $j = $i - $dec;
            while ($guard < $a[$j] && $j >= 0) {
                $a[$j + $dec] = $a[$j];//把被比较值迁移一个增量的位置
                $j -= $dec;
            }
            $a[$j + $dec] = $guard;
        }
        echo implode(' ', $a) . "<br>";
    }
}

shellsSort($list_todo);