<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/23
 * Time: 15:23
 */

/**
 * 需求是：把这些条纹按照颜色排好，红色的在上半部分，白色的在中间部分，蓝色的在下半部分，我们把这类问题称作荷兰国旗问题。
 *
 * 我们把荷兰国旗问题用数组的形式表达一下是这样的：
 *
 * 给定一个整数数组，给定一个值K，这个值在原数组中一定存在，要求把数组中小于K的元素放到数组的左边，大于K的元素放到数组的右边，等于K的元素放到数组的中间，最终返回一个整数数组，其中只有两个值，分别是等于K的数组部分的左右两个下标值。
 *
 * 例如，给定数组：[2, 3, 1, 9, 7, 6, 1, 4, 5]，给定一个值4，那么经过处理原数组可能得一种情况是：[2, 3, 1, 1, 4, 9, 7, 6, 5]，需要注意的是，小于4的部分不需要有序，大于4的部分也不需要有序，返回等于4部分的左右两个下标，即[4, 4]
 */

$arr = [0, 1, 2, 1, 1, 2, 0, 2, 1, 0];

function NetherlandsFlagSort($arr, $pivot)
{
    $less = 0;
    $cur = 0;
    $more = count($arr) - 1;
    colorize($arr, [$less => "green", $more => "red", $cur => 'orange']);
    while ($cur < $more) {
        if ($arr[$cur] < $pivot) {
            swap($arr, $cur++, $less++);
        } elseif ($arr[$cur] > $pivot) {//为何在与较大值交换后当前cur指针不变,盖因为和较小值对比不同,较小值交换后已经是有序的数据,而较大值交换过来的不确定
            swap($arr, $cur, $more--);
        } else {
            $cur++;
        }
        colorize($arr, [$less => "orange", $more => "red", $cur => 'green']);
    }
}

function swap(&$arr, $i, $j)
{
    if ($i != $j) {
        $temp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $temp;
    }

}

function colorize(array $arr, array $config)
{
    $res = [];
    for ($i = 0; $i < count($arr); $i++) {
        $res[] = isset($config[$i]) ? "<font color={$config[$i]}>$arr[$i]</font>" : $arr[$i];
    }
    echo implode(',', $res), "<br>";
}

function dualColorSort(array $arr)
{
    $less = 0;
    $right = count($arr) - 1;

    $cur = 0;

}


NetherlandsFlagSort($arr, 1);


