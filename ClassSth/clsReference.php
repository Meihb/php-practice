<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/12/18
 * Time: 15:11
 */

class my
{
    public $name;
    public $age;

    function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
}

$m1 = new my("mhb", 20);
$m2 = $m1;//看起来 对象不是copy,而是reference
var_dump($m1,$m1);
$m2->name = "mhb1";
var_dump($m2,$m1);