<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/1/5
 * Time: 14:19
 */


include_once "MyNumber.php";
$number = new MyNumber();
echo $number::$num;
echo myNumber::$num;

$number2 = new MyNumber();
echo MyNumber::$num;