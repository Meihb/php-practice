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
//echo $result;//输出 100+summary

/*
 * array_filter ( array $array [, callable $callback [, int $flag = 0 ]] ) : array
 *
 * 保留key
 */
function odd($var)
{
    // returns whether the input integer is odd
    return ($var & 1);
}

function even($var)
{
    // returns whether the input integer is even
    return (!($var & 1));
}

$array1 = array("a" => 1, "b" => 2, "c" => 3, "d" => 4, "e" => 5);
$array2 = array(6, 7, 8, 9, 10, 11, 12);

//echo "Odd :\n";
//print_r(array_filter($array1, "odd"));
//echo "Even:\n";
//print_r(array_filter($array2, "even"));

/*
 * array_map — 为数组的每个元素应用回调函数
 * array_map ( callable $callback , array $array , array ...$arrays ) : array
 */
function show_Spanish($n, $m)
{
    return "The number {$n} is called {$m} in Spanish";
}

function map_Spanish($n, $m)
{
    return [$n => $m];
}

$a = [1, 2, 3, 4, 5];
$b = ['uno', 'dos', 'tres', 'cuatro', 'cinco'];

$c = array_map('show_Spanish', $a, $b);
var_export($c);

$d = array_map('map_Spanish', $a, $b);
var_export($d);

function callback($k, $v)
{
    return "key is '{$k}';value is '$v'";
}

$res = array_map("callback", array_keys($c), $c);//太秀了吧,array_map不能传入keys,所以用array_keys()加入
var_export($res);

/*
 * array_walk ( array &$array , callable $callback [, mixed $userdata = null ] ) : bool
将用户自定义函数 funcname 应用到 array 数组中的每个单元。
array_walk() 不会受到 array 内部数组指针的影响。array_walk() 会遍历整个数组而不管指针的位置。

userdata
如果提供了可选参数 userdata，将被作为第三个参数传递给 callback funcname。

Calling an array Walk inside a class
If the class is static:
array_walk($array, array('self', 'walkFunction'));
or
array_walk($array, array('className', 'walkFunction'));

Otherwise:
array_walk($array, array($this, 'walkFunction'));
 */

$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");

function test_alter(&$item1, $key, $prefix)
{
    $item1 = "$prefix: $item1";
}

function test_print($item2, $key)
{
    echo "$key. $item2<br />\n";
}

echo "Before ...:\n";
array_walk($fruits, 'test_print');

array_walk($fruits, 'test_alter', 'fruit');
echo "... and after:\n";

array_walk($fruits, 'test_print');