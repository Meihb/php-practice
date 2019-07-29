<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-8-16
 * Time: 10:21
 */

$redis = new RedisIns();
$redis->connect('127.0.0.1', 6379);
echo "Connection to server sucessfully";
//查看服务是否运行
echo "Server is running: " . $redis->ping();