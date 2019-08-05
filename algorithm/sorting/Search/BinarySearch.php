<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/5
 * Time: 17:13
 */

//二分查找


/**
 * @param array $arr
 * @param int $neddle
 * @return bool
 */
function binartSearch(array $arr, int $neddle)
{
    $low = 0;
    $high = count($arr) - 1;

    while ($low <= $high) {
        $middle = intval(($low + $high) / 2);
        echo "low:$low,high:$high,middle:$middle,value:" . $arr[$middle]."<br>";
        if ($neddle > $arr[$middle]) {
            $low = $middle + 1;
        } elseif ($neddle < $arr[$middle]) {
            $high = $middle - 1;
        } else {
            return true;
        }
    }

    return false;
}

$arr = [1, 3, 4, 6, 7, 8, 10, 13, 14, 18, 19, 21, 24, 37, 40, 45, 71];
var_dump(binartSearch($arr, 1));