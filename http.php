<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-5
 * Time: 16:51
 */

//print_r($_REQUEST);
//print_r($_SERVER);
$html = file_get_contents("http://www.baidu.com");
//print_r($http_response_header);
$fp = fopen('http://www.baidu.com', 'r');
//print_r(stream_get_meta_data($fp));
fclose($fp);


//创建socket
//$resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//绑定端口和地址
//$bind = socket_bind($resource, '122.112.248.56', 7777);
//监听
//$listen = socket_listen($resource, 0);
//设置非阻塞模式,在没有得到结果之前,该函数不会阻塞当前线程,而会立即返回;阻塞:不得到结果不返回
//$block = socket_set_block($resource);
//写入
//$write = socket_write($resource, '');
//读取
//$read = socket_read($resource, 2014, PHP_BINARY_READ);
//长连接,client方与Server方建立长连接,为之后的报文发送与读取做准备
//$pfsockopen = pfsockopen($hostname,$port,);
/****socket控制选项***********/
//socket_set_option($resource, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 1, 'usec' => 0]);
//socket_set_option($resource, SOL_SOCKET, SO_SNDTIMEO, ['sec' => 3, 'usec' => 0]);
//socket_last_error($resource)


/*******简易socket*******/
$host = '127.0.0.1';
$port = 7777;
set_time_limit(0);//设置超时
//创建socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("could not create socket \n");
//绑定端口
$resutl = socket_bind($socket, $host, $port) or die("could not bind to socket \n");
//开始监听
$result = socket_listen($socket, 3) or die("could not listen to socket \n");
//读取连接请求并调用另一个子socket处理客户端-服务端信息
$spawn = socket_accept($socket) or die('Could not accept incoming connection \n');
//读取客户端输入
$input = socket_read($spawn,1024)or die('Could not read input \n');
//
$output = strrev(trim($input));
socket_write($spawn,$output,strlen($output)) or die('Could not write \n');