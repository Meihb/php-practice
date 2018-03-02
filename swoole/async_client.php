<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-11-2
 * Time: 15:24
 */
//异步client 仅支持cli模式
$client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
$client->on("connect", function(swoole_client $cli) {

    var_dump($cli->isConnected()); // true
    var_dump($cli->getsockname()); //['port' => 57305, 'host'=> '127.0.0.1']
    var_dump($cli->sock); // 5

    $i = 0;
    while ($i < 100) {
        $cli->send($i."\n");
        $i++;
    }
    //关闭
    //$cli->close();
});

$client->on("receive", function($cli, $data){
    echo "Receive: $data";
});

$client->on("error", function(swoole_client $cli){
    echo "error\n" . $cli->errCode;
});

$client->on("close", function(swoole_client $cli){
    echo "Connection close\n";
});

$client->connect('127.0.0.1', 9501);