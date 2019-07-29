<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/29
 * Time: 14:18
 */

require_once '../RedisIns.php';
$redis = new \RedisIns();

$redis->setex('order_id', 10, 123);