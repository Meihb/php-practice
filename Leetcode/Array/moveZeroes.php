<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/20
 * Time: 15:45
 */


class Solution
{
    /*
     *   移动零
    给定一个数组 nums，编写一个函数将所有 0 移动到数组的末尾，同时保持非零元素的相对顺序。

    示例:

    输入: [0,1,0,3,12]
    输出: [1,3,12,0,0]
    说明:

    必须在原数组上操作，不能拷贝额外的数组。
    尽量减少操作次数。
     */
    /**
     * @param Integer[] $nums
     * @return NULL
     */
    function moveZeroes(&$nums)
    {
        $zeroNums = 0;
        for ($i = 0; $i < count($nums); $i++) {
            if ($nums[$i] != 0) {
                if ($zeroNums > 0) {
                    $nums[$i - $zeroNums] = $nums[$i];
                    $nums[$i] = 0;
                }
            } else {
                $zeroNums++;
            }
        }
        return;

    }
    /*
     *  两数之和
给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那 两个 整数，并返回他们的数组下标。

你可以假设每种输入只会对应一个答案。但是，你不能重复利用这个数组中同样的元素。

示例:

给定 nums = [2, 7, 11, 15], target = 9

因为 nums[0] + nums[1] = 2 + 7 = 9
所以返回 [0, 1]
     */

    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum($nums, $target)
    {
        $result = [];
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            for ($j = $i + 1; $j < $len; $j++) {
                if (!is_null($nums[$i]) && !is_null($nums[$j]) && $nums[$i] + $nums[$j] == $target) {
                    return $result = [$i, $j];
                }

            }
        }
        return $result;
    }


    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum2($nums, $target)
    {
        $result = [];
        $arr = [];
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            $value = $nums[$i];
            $minus = $target - $value;
            if (isset($arr[$minus])) return [$arr[$minus], $i];
            $arr[$value] = $i;


        }
        return $result;
    }

    /*
     *   有效的数独
判断一个 9x9 的数独是否有效。只需要根据以下规则，验证已经填入的数字是否有效即可。

数字 1-9 在每一行只能出现一次。
数字 1-9 在每一列只能出现一次。
数字 1-9 在每一个以粗实线分隔的 3x3 宫内只能出现一次。


上图是一个部分填充的有效的数独。

数独部分空格内已填入了数字，空白格用 '.' 表示。

示例 1:

输入:
[
  ["5","3",".",".","7",".",".",".","."],
  ["6",".",".","1","9","5",".",".","."],
  [".","9","8",".",".",".",".","6","."],
  ["8",".",".",".","6",".",".",".","3"],
  ["4",".",".","8",".","3",".",".","1"],
  ["7",".",".",".","2",".",".",".","6"],
  [".","6",".",".",".",".","2","8","."],
  [".",".",".","4","1","9",".",".","5"],
  [".",".",".",".","8",".",".","7","9"]
]
输出: true
示例 2:

输入:
[
  ["8","3",".",".","7",".",".",".","."],
  ["6",".",".","1","9","5",".",".","."],
  [".","9","8",".",".",".",".","6","."],
  ["8",".",".",".","6",".",".",".","3"],
  ["4",".",".","8",".","3",".",".","1"],
  ["7",".",".",".","2",".",".",".","6"],
  [".","6",".",".",".",".","2","8","."],
  [".",".",".","4","1","9",".",".","5"],
  [".",".",".",".","8",".",".","7","9"]
]
输出: false
解释: 除了第一行的第一个数字从 5 改为 8 以外，空格内其他数字均与 示例1 相同。
     但由于位于左上角的 3x3 宫内有两个 8 存在, 因此这个数独是无效的。
}



        /**
         * @param Integer[] $arr
         */
    function validate(array $arr)
    {
        $tmp = [];
        for ($i = 0; $i < count($arr); $i++) {
            $value = $arr[$i];
            if ($value != '.') {
                if (isset($tmp[$value])) {
//                        echo implode(',', $arr) . '存在重复' . $value . "<br>\r\n";
                    return false;
                }
                $tmp[$value] = 1;
            }
        }
        return true;
    }

    /**
     * @param String[][] $board
     * @return Boolean
     */
    function isValidSudoku($board)
    {


        //鉴别横向
        $longitudes = [];
        $triples = [];
        foreach ($board as $key => $lateral) {
            if (!$this->validate($lateral)) {
                return false;
            }

            foreach ($lateral as $k2 => $v2) {
                if ($v2 != '.') {
                    //分配纵向
                    $longitudes[$k2][] = $v2;
                    //分配 3*3
                    $serialNum = 3 * intval(($key) / 3) + intval(($k2) / 3);//之前错误为key+1,想当然了
                    $triples[$serialNum][] = $v2;
                }

            }

        }
//        var_dump($longitudes, $triples);
        //竖向鉴别
        foreach ($longitudes as $longitude) {
            if (!$this->validate($longitude)) {
                return false;
            }
        }

        //3*3鉴别
        foreach ($triples as $triple) {
            if (!$this->validate($triple)) {
                return false;
            }
        }

        return true;

    }

    /**
     *  旋转图像
     * 给定一个 n × n 的二维矩阵表示一个图像。
     *
     * 将图像顺时针旋转 90 度。
     *
     * 说明：
     *
     * 你必须在原地旋转图像，这意味着你需要直接修改输入的二维矩阵。请不要使用另一个矩阵来旋转图像。
     *
     * 示例 1:
     *
     * 给定 matrix =
     * [
     * [1,2,3],
     * [4,5,6],
     * [7,8,9]
     * ],
     *
     * 原地旋转输入矩阵，使其变为:
     * [
     * [7,4,1],
     * [8,5,2],
     * [9,6,3]
     * ]
     * 示例 2:
     *
     * 给定 matrix =
     * [
     * [ 5, 1, 9,11],
     * [ 2, 4, 8,10],
     * [13, 3, 6, 7],
     * [15,14,12,16]
     * ],
     *
     * 原地旋转输入矩阵，使其变为:
     * [
     * [15,13, 2, 5],
     * [14, 3, 4, 1],
     * [12, 6, 8, 9],
     * [16, 7,10,11]
     * ]
     */

    /**
     * 每次处理一个n边长的正方形,在处理n-2的正方形,
     * @param Integer[][] $matrix
     * @return NULL
     */
    function rotate(&$matrix)
    {
        $matrixLength = count($matrix);
        $deepLength = floor($matrixLength / 2);

        for ($i = 0; $i < $deepLength; $i++) {
            $sideLength = $matrixLength - 2 * $i;
            $leftup = ($matrix[$i])[$i];
            $rightUp = ($matrix[$i])[$i + $sideLength - 1];
            $leftDown = ($matrix[$i + $sideLength - 1])[$i];
            $rightDown = ($matrix[$i + $sideLength - 1])[$i + $sideLength - 1];
            $tmp = array_slice($matrix[$i], $i, $sideLength);
            //左边 平移到 上边
            for ($j = $i; $j <= $i + $sideLength - 1; $j++) {//要从两个边重叠的地方开始遍历,以免边缘参数被提前改变
                $pos = $sideLength - 1 - ($j - $i) + $i;
//                echo "matrix[$j][$i]平移到matrix[$i][$pos]\r\n";
//                var_dump(($matrix[$j])[$i], ($matrix[$i])[$pos]);
                $matrix[$i][$pos] = $matrix[$j][$i];
            }
//            echo '左边 平移到 上边' . "<br>\r\n";
//            var_dump($matrix);
            //下边平移到 左边
            for ($j = $i; $j <= $i + $sideLength - 1; $j++) {
                $pos = ($j - $i) + $i;
//                echo "matrix[$i + $sideLength - 1][$j]平移到matrix[$pos][$i]\r\n";
//                var_dump($matrix[$i + $sideLength - 1][$j], $matrix[$pos][$i]);
                $matrix[$pos][$i] = $matrix[$i + $sideLength - 1][$j];
            }
//            echo '下边平移到 左边' . "<br>\r\n";
//            var_dump($matrix);
            //右边 平移到 下边
            for ($j = $i + $sideLength - 1; $j >= $i; $j--) {
                $pos = $i+$sideLength - 1 - $j + $i;
//                echo "i is $i,j is $j\r\n";
//                echo "matrix[$j][$i + $sideLength - 1][$j]平移到matrix[$i + $sideLength - 1][ $sideLength - 1 - $j + $i]\r\n";
//                var_dump($matrix[$j][$i + $sideLength - 1], $matrix[$i + $sideLength - 1][$pos]);
                $matrix[$i + $sideLength - 1][$pos] = $matrix[$j][$i + $sideLength - 1];
            }
//            echo '右边 平移到 下边' . "<br>\r\n";
//            var_dump($matrix);
            //将tmp数组 平移到 右边
            for ($j = 0; $j < $sideLength; $j++) {
                $matrix[$i + $j][$i + $sideLength - 1] = $tmp[$j];
            }
//            echo "第$i 次上到右" . "<br>\r\n";
//            var_dump($matrix);
        }
        return;
    }

}

//$testArr = [["8", "3", ".", ".", "7", ".", ".", ".", "."], ["6", ".", ".", "1", "9", "5", ".", ".", "."], [".", "9", "8", ".", ".", ".", ".", "6", "."], ["8", ".", ".", ".", "6", ".", ".", ".", "3"], ["4", ".", ".", "8", ".", "3", ".", ".", "1"], ["7", ".", ".", ".", "2", ".", ".", ".", "6"], [".", "6", ".", ".", ".", ".", "2", "8", "."], [".", ".", ".", "4", "1", "9", ".", ".", "5"], [".", ".", ".", ".", "8", ".", ".", "7", "9"]];
//var_dump((new Solution())->isValidSudoku($testArr));
$testArr = [[5, 1, 9, 11], [2, 4, 8, 10], [13, 3, 6, 7], [15, 14, 12, 16]];
//$testArr = [[4, 8], [3, 6]];
var_dump((new Solution())->rotate($testArr));
var_dump($testArr);


