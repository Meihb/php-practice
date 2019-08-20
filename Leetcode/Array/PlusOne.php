<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/20
 * Time: 15:17
 */

/*
 * 加一
 * 给定一个由整数组成的非空数组所表示的非负整数，在该数的基础上加一。

最高位数字存放在数组的首位， 数组中每个元素只存储单个数字。

你可以假设除了整数 0 之外，这个整数不会以零开头。

示例 1:

输入: [1,2,3]
输出: [1,2,4]
解释: 输入数组表示数字 123。
示例 2:

输入: [4,3,2,1]
输出: [4,3,2,2]
解释: 输入数组表示数字 4321。
 */

class Solution
{

    /**
     * @param Integer[] $digits
     * @return Integer[]
     */
    function plusOne($digits)
    {
        $len = count($digits);
        $tmp = 0;
        for ($i = $len - 1; $i >= 0; $i--) {
            $value = $digits[$i];
            if ($len - 1 == $i) {
                $value++;
            }
            $sum = $value + $tmp;
            $tmp = intval($sum / 10);
            $digits[$i] = $sum % 10;
        }
        if ($tmp > 0) array_unshift($digits, $tmp);
        return $digits;
    }
}