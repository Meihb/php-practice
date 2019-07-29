<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/29
 * Time: 14:14
 */

require_once '../RedisIns.php';
$redis = new \RedisIns();
// 解决Redis客户端订阅时候超时情况
$redis->setOption();
$redis->psubscribe(array('__keyevent@0__:*'), 'keyCallback');
// 回调函数,这里写处理逻辑
function keyCallback($redis, $pattern, $chan, $msg)
{
    echo "Pattern: $pattern\n";
    echo "Channel: $chan\n";
    echo "Payload: $msg\n\n";
}

