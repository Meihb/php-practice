<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/12/11
 * Time: 13:25
 */

$redis = new  \Redis();
$redis->connect('127.0.0.1', '16379');
$key_name = $_GET['key'] ?: 'test_sf';
$redis->del($key_name,$key_name."_total");
echo json_encode(['count' => $redis->sCard($key_name), 'total' => $redis->get($key_name . "_total")]);