<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/26
 * Time: 11:46
 */
$redis = new Redis();
$redis->connect("127.0.0.1");
$redis->ping();
//$redis->setOption(Redis::OPT_READ_TIMEOUT, -1);

//var_dump($redis->config('get', 'notify-keyspace-events'));

try {
    $redis->subscribe(['chanel1'], function ($redis, $chan, $msg) {
        echo "Channel: $chan\n";
        echo "Payload: $msg\n";
    });
} catch (Exception $exception) {
    echo 'exception:' . $exception->getMessage();
}