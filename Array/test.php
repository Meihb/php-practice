<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/12/16
 * Time: 11:23
 */

//测试 array_map array_reduce array_walk等iterable 类型函数

$arr = [1 => 2, 2 => 3, 3 => 5, 4 => 8];
/*
 * array_reduce ( array $array , callable $callback [, mixed $initial = null ] ) : mixed
 * callback ( mixed $carry , mixed $item ) : mixed
 */
$result = array_reduce($arr, function ($carry, $item) {
    return $item + $carry;
}, 100);
echo $result;//输出 100+summary
