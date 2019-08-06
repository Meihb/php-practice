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
    for ($i = 0; $i < $len - 1; $i++) {
        $minKey = SelectMinKey($arr, $len, $i);
        if ($minKey != $i) {
            $temp = $arr[$minKey];
            $arr[$minKey] = $arr[$i];
            $arr[$i] = $temp;
        }
        print_list($arr, $len, $i);
    }
}

/**
 * 查找数组从$i-($n-1)位置的最小值的key
 * @param array $arr
 * @param $n
 * @param $i
 * @return $minkey int 最小值的key
 */
function SelectMinKey(array $arr, $n, $i)
{
    $minKey = $i;
    for ($j = $i + 1; $j < $n; $j++) {
        if ($arr[$j] < $arr[$minKey]) {
            $minKey = $j;
        }
    }
    return $minKey;
}

require "../common.php";
SimpleSelection($list_todo);