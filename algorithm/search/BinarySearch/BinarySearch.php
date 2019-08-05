<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/5
 * Time: 17:13
 */

//二分查找


/**
 * 迭代版本
 * @param array $arr
 * @param int $neddle
 * @return bool
 */
function binarySearch(array $arr, int $needle)
{
    $low = 0;
    $high = count($arr) - 1;

    while ($low <= $high) {
        $middle = intval(($low + $high) / 2);
        echo "low:$low,high:$high,middle:$middle,value:" . $arr[$middle] . "<br>";
        if ($needle > $arr[$middle]) {
            $low = $middle + 1;
        } elseif ($needle < $arr[$middle]) {
            $high = $middle - 1;
        } else {
            return true;
        }
    }

    return false;
}

function binarySearchRecursion(array $arr, int $needle, int $low, int $high)
{
    if ($high < $low) return false;

    $middle = (int)(($high + $low) / 2);

    if ($arr[$middle] < $needle) {
        return binarySearchRecursion($arr, $needle, $middle + 1, $high);
    } elseif ($arr[$middle] > $needle) {
        return binarySearchRecursion($arr, $needle, $low, $middle - 1);
    } else {
        return true;
    }
}

$arr = [1, 3, 4, 6, 7, 8, 10, 13, 14, 18, 19, 21, 24, 37, 40, 45, 71];
var_dump(binarySearch($arr, 13));