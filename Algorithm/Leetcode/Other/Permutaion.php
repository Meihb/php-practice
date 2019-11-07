<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/11/5
 * Time: 18:22
 */

/*全排列就是从n个不同元素中任取m（m≤n）个元素，按照一定的顺序排列起来，叫做从n个不同元素中取出m个元素的一个排列，当m=n时所有的排列情况叫全排列。*/

$str = 'abc';
// 字符串转换为数组
$arr = str_split($str);
// 调用perm函数
//perm1($arr, 0, count($arr) - 1);
/**
 * 定义perm函数
 * @param [array] $arr // 排列的字符串
 * @param [int] $default // 初始值
 * @param [int] $max // 最大值
 */
function perm1(&$arr, $default, $max)
{
    // 初始值是否等于最大值
    if ($default == $max) {
        // 将数组转换为字符串
        echo join('', $arr), PHP_EOL;
    } else {
        // 循环调用函数
        for ($i = $default; $i <= $max; $i++) {
            // 调用swap函数
            swap($arr[$default], $arr[$i]);
            // 递归调用自己
            perm1($arr, $default + 1, $max);
            // 再次调用swap函数
            swap($arr[$default], $arr[$i]);
        }
    }
}

function swap(&$a, &$b)
{
    $c = $a;
    $a = $b;
    $b = $c;
}

/**
 * 从第
 * @param $arr
 * @param $m
 * @param $n
 */
function permutation($arr, $m, $n)
{
    if ($m == $n) {
        echo implode(',', $arr) . PHP_EOL,"<br>";
    } else {
        for ($i = $m; $i <= $n; $i++) {
            swap2($arr, $m, $i);
            permutation($arr, $m + 1, $n);
            swap2($arr, $m, $i);
        }
    }
}

function swap2(&$arr, $i, $j)
{
    $tmp = $arr[$i];
    $arr[$i] = $arr[$j];
    $arr[$j] = $tmp;
}

permutation([1, 2, 3, 4], 0, 3);