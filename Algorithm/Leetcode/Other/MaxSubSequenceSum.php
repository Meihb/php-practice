<?php

/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/26
 * Time: 10:13
 */

/*
 * 求一个数列 连续和最大的子列 ,A=[A0,A1...AN-1],求∑ij A的最大值
 */

class Solution
{

    /**
     * O(n^2)
     * @param array $nums
     * @return int|mixed
     */
    public function maxSubSequenceSum1(array $nums)
    {
        $maxSum = 0;
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            $thisSum = 0;
            for ($j = $i; $j < $len; $j++) {
                $thisSum += $nums[$j];
                $maxSum = max($maxSum, $thisSum);
            }
        }
        return $maxSum;

    }


    /**
     * divide and conquer
     * 分为左列右列,治则考虑左列最大、右列最大、跨界最大三种情况
     * @param array $nums
     * @return int|mixed
     */
    public function maxSubSequenceSum2(array $nums, int $left, int $right)
    {
        if ($left == $right) return $nums[$left];

        $middle = intval(($left + $right) / 2);
        $maxLeftSum = $this->maxSubSequenceSum2($nums, $left, $middle);
        $maxRightSum = $this->maxSubSequenceSum2($nums, $middle + 1, $right);

        //从middle开始像两边找寻最大跨边界和
        $maxCrossSum = 0;
        $leftSum = $nums[$middle];
        $rightSum = $nums[$middle + 1];

        $tmpSum = 0;
        for ($i = $middle; $i >= $left; $i--) {
            $tmpSum += $nums[$i];
            $leftSum = max($leftSum, $tmpSum);
        }
        $tmpSum = 0;
        for ($i = $middle + 1; $i <= $right; $i++) {
            $tmpSum += $nums[$i];
            $rightSum = max($rightSum, $tmpSum);
        }
        $maxCrossSum = $leftSum + $rightSum;

        return max($maxLeftSum, $maxRightSum, $maxCrossSum);

    }


    /**
     * 在线处理
     * @param $nums
     * @return int
     */
    public function maxSubSequenceSum4($nums)
    {
        $maxSum = $nums[0];
        $thisSum = 0;

        for ($i = 0; $i < count($nums); $i++) {
            $thisSum += $nums[$i];

            if ($thisSum > $maxSum) {
                $maxSum = $thisSum;//发现更大和更新
            } elseif ($thisSum < 0) {//累加当前述导致最大和减少,不更新,即次数不在当前最大子列和当中
                $thisSum = 0;//不能是后面的部分和变大,抛弃
            }
        }

        return $maxSum;
    }


    /**
     * 在线处理
     * @param $nums
     * @return int
     */
    public function maxSubSequenceSum5($nums)
    {
        $maxSum = $nums[0];
        $thisSum = 0;

        for ($i = 0; $i < count($nums); $i++) {
            if ($thisSum > 0) {
                $thisSum += $nums[$i];
            } else {
                $thisSum = $nums[$i];
            }
            $maxSum = max($thisSum, $maxSum);
        }

        return $maxSum;
    }

}

var_dump((new Solution())->maxSubSequenceSum5([-2, 1, -3, 4, -1, 2, 1, -5, 4] ));