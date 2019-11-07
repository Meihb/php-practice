<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/11/5
 * Time: 9:42
 */


/*
 * redis php在同在本地调试的时候呀我怎么觉得是序列化处理的？？？
 */
$redis = new Redis();
$redis->connect('127.0.0.1');


$redis->set('keyTest', 10);
var_dump($redis->get('keyTest'));

$redis->setBit();