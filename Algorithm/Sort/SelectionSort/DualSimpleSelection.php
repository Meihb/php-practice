<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/30
 * Time: 14:59
 */

/*
 * 选择排序 即从当元素中找出最小元素,作为最终排列结果的第一个,以此类推
 */

function SimpleSelection(array $arr)
{
    $len = count($arr);
    print_list($arr, $len, -1);
    for ($i = 0; $i < $len / 2; $i++) {//由于每次查找已然查找了最大值和最小值,则只需遍历n/2次即可
        list($minKey, $maxKey) = SelectMinAndMaxKey($arr, $len, $i);
        var_dump($minKey, $maxKey);
        echo "<br>";
        if ($minKey != $i) {
            $temp = $arr[$minKey];
            $arr[$minKey] = $arr[$i];
            $arr[$i] = $temp;
        }
        if ($maxKey != ($len - 1 - $i)) {//末位记得清楚
            $temp = $arr[$maxKey];
            $arr[$maxKey] = $arr[$len - 1 - $i];
            $arr[$len - 1 - $i] = $temp;
        }
        print_list($arr, $len, $i);
    }
}

/**
 * @param array $arr
 * @param $n
 * @param $i
 * @return array
 */
function SelectMinAndMaxKey(array $arr, $n, $i)
{
    $minKey = $maxKey = $i;
    for ($j = $i + 1; $j < $n - $i; $j++) {
        if ($arr[$j] < $arr[$minKey]) {
            $minKey = $j;
        }
        if ($arr[$j] > $arr[$maxKey]) {
            $maxKey = $j;
        }
    }
    return [$minKey, $maxKey];
}

require "../common.php";
SimpleSelection($list_todo);