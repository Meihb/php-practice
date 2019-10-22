<?php
/**
 * Created by PhpStorm.
 * User: 12538
 * Date: 2019-8-2
 * Time: 23:59
 */

require_once "../common.php";


/**
 * merge arr[m:i]和arr[i+1:n]
 * @param array $src
 * @param array $result
 * @param   $start int
 * @param   $end int
 * #param $middle int
 * @return array
 */
function merge(array $src, array $result, $start, $end, $middle)
{
    echo 'start merge:' . implode(',', $src) . "<br>";
    echo "from $start to $middle merge with " . ($middle + 1) . " to $end" . "<br>";
    $leftArr = implode(',',array_slice($src, $start, $middle - $start + 1));
    $rightArr = implode(',',array_slice($src, $middle+1, $end - $middle));
    echo "Thus $leftArr merge with $rightArr <br>";
    for ($j = $start, $k = $middle + 1; $j <= $middle && $k <= $end;) {
        $src[$j] <= $src[$k] ? $result[$start++] = $src[$j++] : $result[$start++] = $src[$k++];
    }
    //小数组本身认定为已排序的,故多余的数列直接插到尾部
    while ($j <= $middle) $result[$start++] = $src[$j++];
    while ($k <= $end) $result[$start++] = $src[$k++];

    echo "sorted as " . implode(',', $result) . "<br>";
    return $result;
}


/**
 * 归并迭代算法
 * 这个写的不好,自己把自己绕晕了
 * @param array $arr
 * @return array
 */
function mergeSort(array $arr)
{
    echo '迭代归并方法:<br>';
    $length = count($arr);
    if ($length < 2) return $arr;
    $inc = 1;//每个子序列长度
    while ($inc < $length) {//不必考虑等于数组长度的情况
        echo "inc:$inc<br>";
        $subLength = $inc * 2;//每一对组 的长度,故为两倍子序列长度
        for ($i = 0; $i <= intval($length / $subLength); $i++) {//此=需考虑，否则将会导致奇数长度数列最后一个数字无法排列
            $start = $subLength * $i;
            $middle = $start + $inc - 1;
            $end = $start + $subLength - 1 > $length - 1 ? $length - 1 : $start + $subLength - 1;//要考虑到最后一组队列的尾部不足
            if ($middle < $length - 1) $arr = merge($arr, $arr, $start, $end, $middle);//成对才考虑归并
        }
        $inc = $inc * 2;


    }
    return $arr;

}

function mergeSort2(array $arr)
{
    echo '迭代归并方法:<br>';
    $length = count($arr);
    if ($length < 2) return $arr;
    $inc = 1;//初试子序列长度

    while ($inc < $length) {//满足归并条件,即至少存在一对子序列
        $pairLen = $inc * 2;//一对子序列长度
        $pos = 0;
        while ($pos + $pairLen - 1 <= $length - 1) {//在此范围内的都是等长的子序列对，为什么左边是-1,需要注意,容易忽略此错误
            $arr = merge($arr, $arr, $pos, $pos + $pairLen - 1, $pos + $inc - 1);
            $pos += $pairLen;
        }
        //此时已无等长子序列对,只剩下两种情况,要么一个子序列长度都不足,此情况无需处理,要么不等长子序列对,需要处理
        if ($pos + $inc - 1 < $length - 1) {//同理左边-1,为何不取等,取等情况下只有一个子序列不成对
            //不等长子序列对
            $arr =  merge($arr, $arr, $pos, $length - 1, $pos + $inc - 1);
        }
        $inc = $inc * 2;
    }

    echo 'results:' . implode(',', $arr)."<br>";
    return $arr;

}


function dcMerge($leftArr, $rightArr)
{
    echo 'start merge:' . implode(',', $leftArr) . 'and' . implode(',', $rightArr) . "<br>";
    $result = [];
    for ($i = 0, $j = 0; $i < count($leftArr) && $j < count($rightArr);) {
        if ($leftArr[$i] <= $rightArr[$j]) {
            $result[] = $leftArr[$i++];
        } else {
            $result[] = $rightArr[$j++];
        }
    }
    while ($i < count($leftArr)) $result[] = $leftArr[$i++];
    while ($j < count($rightArr)) $result[] = $rightArr[$j++];
    echo "sorted as " . implode(',', $result) . "<br>";
    return $result;
}

/**
 * 二路归并分治法
 * @param array $arr
 * @return array
 */
function divideAndConquerSort(array $arr)
{
    $length = count($arr);
    if ($length < 2) return $arr;

    $middle = ceil($length / 2);
    $left_arr = array_slice($arr, 0, $middle);
    $right_arr = array_slice($arr, $middle);
    echo '$left_arr:' . implode(',', $left_arr) . ' , $right_arr:' . implode(',', $right_arr) . "while middle is {$middle}<br>";
    if (count($left_arr) > 1) {
        $left_arr = divideAndConquerSort($left_arr);
    }
    if (count($right_arr) > 1) {
        $right_arr = divideAndConquerSort($right_arr);
    }


    return dcMerge($left_arr, $right_arr);
}

//$arr = mergeSort($list_todo);
//echo 'results:' . implode(',', $arr);


//$arr = divideAndConquerSort($list_todo);
//echo 'results:' . implode(',', $arr);

$arr = mergeSort2($list_todo);
echo 'results:' . implode(',', $arr);




