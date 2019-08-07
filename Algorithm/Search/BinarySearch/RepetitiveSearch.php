<?php
/**
 * Created by PhpStorm.
 * User: 12538
 * Date: 2019-8-5
 * Time: 19:43
 */


//重复二分查找的首次出现位置,其实就是找到位置以后在其左边(假设数据按照由小往大排列)继续寻找
function repetitiveBinarySearch(array $arr, int $needle)
{
    $low = 0;
    $high = count($arr) - 1;
    $firstIndex = -1;

    while ($low <= $high) {
        $middle = intval(($low + $high) / 2);
        if ($arr[$middle] < $needle) {
            $low = $middle + 1;
        } elseif ($arr[$middle] > $needle) {
            $high = $middle - 1;
        } else {//值相等,依旧查询左边
            $firstIndex = $middle;
            $high = $middle - 1;
        }
    }
    return $firstIndex;
}

//$arr = [1, 1, 1, 2, 3, 4, 5, 5, 5, 5, 5, 6, 7, 8, 9, 10];
//var_dump(repetitiveBinarySearch($arr, 5));


function repetitiveBinarySearchRecursion(array $arr, int $needle, int $low, int $high, $firstIndex)
{
    if ($low > $high) return $firstIndex;
    $middle = intval(($low + $high) / 2);

    if ($needle > $arr[$middle]) {
        $firstIndex = repetitiveBinarySearchRecursion($arr, $needle, $middle + 1, $high, $firstIndex);
    } elseif ($needle < $arr[$middle]) {
        $firstIndex = repetitiveBinarySearchRecursion($arr, $needle, $low, $middle - 1, $firstIndex);
    } else {
        $firstIndex = repetitiveBinarySearchRecursion($arr, $needle, $low, $middle - 1, $firstIndex);
    }
    return $firstIndex;
}

$arr = [1, 1, 1, 2, 3, 4, 5, 5, 5, 5, 5, 6, 7, 8, 9, 10];
var_dump(repetitiveBinarySearch($arr, 5));