<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/6/21
 * Time: 11:33
 */

function xrange($start, $limit, $step)
{
    for ($i = $start; $i <= $limit; $i += $step) {
        yield $i + 1 => $i;//=>其实再次表示了key=>value,即yield返回的上下文是一个包含key value的tuple?
    }
}

//调用generator
//foreach (xrange(0, 100, 1) as $key => $value) {
//    echo $key . ":" . $value . "<br>";
//}


function fib($n)
{
    $cur = 1;
    $prev = 0;

    for ($i = 1; $i <= $n; $i++) {
        yield $i => $cur;

        $temp = $cur;
        $cur = $prev + $cur;
        $prev = $temp;
    }
}

//$fibs = fib(9);
//foreach ($fibs as $key => $fib) {
//    echo "key:" . $key . " while value is " . $fib . "\r\n" . "<br>";
//}

//读取超大文件

function readText()
{
    #code
    $handel = fopen("./test.txt", "rb");
    while (feof($handel) !== false) {
        yield fgets($handel);
    }
}

//foreach (readText() as $value) {
//    echo $value . "<br>";
//}

/**
 * @param $start
 * @param $stop
 * @return Generator
 */
//高访问
function squares($start, $stop)
{
    if ($start < $stop) {
        for ($i = $start; $i <= $stop; $i++) {
            yield $i => $i * $i;
        }
    } else {
        for ($i = $start; $i >= $stop; $i--) {
            yield $i => $i * $i;
        }
    }
}

//对数组进行加权处理
$numbers = ['nike' => 200, 'jordan' => 500, 'adidas' => 800];
//一般方法
function rand_weight($numbers)
{
    $total = 0;
    foreach ($numbers as $number => $value) {
        $total += $value;
        $distribution[$number] = $total;
    }
    $rand = mt_rand(0, $total - 1);

    foreach ($distribution as $num => $weight) {
        if ($rand < $weight) return $num;
    }
}

//yield方法
function mt_rand_weight($numbers)
{
    $total = 0;
    foreach ($numbers as $number => $weight) {
        $total += $weight;
        yield $number => $total;
    }
}

function mt_rand_generator($numbers)
{
    $total = array_sum($numbers);
    $rand = mt_rand(0, $total - 1);
    foreach (mt_rand_weight($numbers) as $num => $weight) {
        if ($rand < $weight) return $num;
    }
}

//echo mt_rand_generator($numbers);

//yield Generaotr::send()接受值

function printer()
{
    while (true) {
        printf("receive:%s\n", yield);
    }
}

//$printer = printer();
//$printer->send("hello");
//$printer->send("world");

$xrange1 = xrange(0, 100, 1);
var_dump($xrange1);
var_dump($xrange1 instanceof Iterator);
echo ($xrange1->key());
echo ("value is " . $xrange1->current())."<br>";
$xrange1->next();//equal to Generator::send() with NULL as argument
echo ($xrange1->key());
echo ("value is " . $xrange1->current())."<br>";