<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/12/11
 * Time: 14:45
 */
require_once 'ShareCode.php';
$key_name = $_GET['key'] ?: 'test_sf';

$num = $_GET['i'];
$code = ShareCode::idToCode($num);
$redis = new  \Redis();
$redis->connect('127.0.0.1', '16379');

$num = $redis->sAdd($key_name, $code);
$redis->incr($key_name . '_total');
echo json_encode(['num' => $num, 'code' => $code]);