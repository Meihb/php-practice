<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/6
 * Time: 10:48
 */
/*
 * 指数搜索,先确定指数级搜索上下限
 *
 */

/**
 * 获取待查询指数,其满足2^(k-1)小于needle,2^k大于needle
 * @param $arr
 * @param $neddle
 */
function getExponentialRange($arr, $needle)
{
    $ex = 1;

    while ($ex < count($arr) && $arr[$ex] < $needle) {
        $ex *= 2;
    }
    echo $arr[intval($ex / 2)], $arr[$ex], $ex . "<br>";

    //执行二分搜索
    $res = (binarySearchRecursion($arr, $needle, intval($ex / 2), min(count($arr) - 1, $ex)));
    var_dump($res, $arr[$res]);
}

function binarySearchRecursion(array $arr, int $needle, int $low, int $high)
{
    if ($low > $high) return -1;
    $middle = intval(($low + $high) / 2);
    echo "low:$low,high:$high,middle:$middle,value:" . $arr[$middle] . "<br>";
    if ($needle > $arr[$middle]) {
        return binarySearchRecursion($arr, $needle, $middle + 1, $high);
    } elseif ($needle < $arr[$middle]) {
        return binarySearchRecursion($arr, $needle, $low, $middle - 1);
    } else {
        return $middle;
    }
}

$arr = [1, 3, 4, 6, 7, 8, 10, 13, 14, 18, 19, 21, 24, 37, 40, 45, 71];
getExponentialRange($arr, 33);