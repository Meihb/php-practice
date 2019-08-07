<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/6
 * Time: 9:17
 */

/*
 * 插值搜索
 *  pos = low+[(key-arr[low])*(high-low)/arr[high]-arr[low]];
 * 本质也是二分法,但是二分搜索在搜索边缘位置的数据时比较慢
 */
function interpolationSearch(array $arr, int $needle)
{
    $low = 0;
    $high = count($arr) - 1;
    while ($low <= $high) {
        $pos = intval(($low + ($needle - $arr[$low]) / ($arr[$high] - $arr[$low]) * ($high - $low)));
        if ($needle > $arr[$pos]) {
            $low = $pos + 1;
        } elseif ($needle < $arr[$pos]) {
            $high = $pos - 1;
        } else {
            return $pos;
        }
    }
    return false;
}

$arr = [1, 3, 4, 6, 7, 8, 10, 13, 14, 18, 19, 21, 24, 37, 40, 45, 71];
var_dump(interpolationSearch($arr, 13));