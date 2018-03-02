<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/1/5
 * Time: 14:25
 */

class MyNumber
{
    static $num = 0;
    public function __construct()
    {
        self::$num++;
    }
}