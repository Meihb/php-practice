<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-15
 * Time: 9:40
 */
header("Content-type: text/html; charset=utf-8");
set_time_limit(0);

$host = "127.0.0.1";
$port = 4001;
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create  socket\n"); // 创建一个Socket

$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  连接
//socket_write($socket, "hello socket") or die("Write failed\n"); // 数据传送 向服务器发送消息


//$buff = socket_read($socket, 1024, PHP_NORMAL_READ);
//        echo("Response was:" . $buff . "\n");

socket_close($socket);