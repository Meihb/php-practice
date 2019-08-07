<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/6
 * Time: 15:55
 */

/**
 * PHP底层C实现中数组本身就是一个哈希表，由于数组是动态的，不必担心数组溢出。我们可以将值存储在关联数组中，以便我们可以将值与键相关联
 * @param array $arr
 * @param int $needle
 * @return bool
 */
function hashSearch(array $arr, int $needle)
{
    return isset($arr[$needle]) ? true : false;
}