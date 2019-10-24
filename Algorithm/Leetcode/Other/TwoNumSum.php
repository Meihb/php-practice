<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/24
 * Time: 10:41
 */
/**
 * 给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那 两个 整数，并返回他们的数组下标。
 *
 * 你可以假设每种输入只会对应一个答案。但是，你不能重复利用这个数组中同样的元素。
 *
 * 给定 nums = [2, 7, 11, 15], target = 9
 *
 * 因为 nums[0] + nums[1] = 2 + 7 = 9
 *
 * 所以返回 [0, 1]
 */


/**
 * hashmap查找 是O(1) 故整体时间复杂度为O(n+1) = O(n)
 * @param $array
 * @param $target
 * @return array
 */
function twoSum($array, $target)
{
    $hash = [];
    for ($i = 0; $i < count($array); $i++) {
        $hash[$array[$i]] = $i;
    }
    for ($i = 0; $i < count($array); $i++) {
        if (isset($hash[$target - $i])) {
            return [$i, $array[$target - $i]];
        }
    }
}


/*
 * nlog(n)时间复杂度算法  二分查找法和 nlogn任意排序算法(堆排序或者归并排序)
 */
function twoSum2($arr, $target)
{

}