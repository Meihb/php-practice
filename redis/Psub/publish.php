<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/26
 * Time: 11:46
 */
$redis = new Redis();
$redis->connect("127.0.0.1");
var_dump($redis->ping());
//$redis->setOption(Redis::OPT_READ_TIMEOUT, -1);


try {
    var_dump($redis->publish('chanel1', 'hello world'));
} catch (Exception$exception) {
    echo 'exception:' . $exception->getMessage();
}

