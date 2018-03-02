<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-7
 * Time: 11:39
 */
//$host = 'localhost';
//$port = 7777;
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) OR DIE("Could not create socket \n");
//$bind = socket_bind($socket, $host, $port) OR DIE("Could not bind to socket \n");
//var_dump($bind,"\r\n");
//$listen = socket_listen($socket, 10);
//var_dump($listen,"\r\n");
//
//do {
//    //接受客户端数据
//    $socket_new = socket_accept($socket) OR DIE("Could not accept socket");
//    var_dump('this is socket_new'.$socket_new);
//    $input = socket_read($socket_new, 1024, PHP_BINARY_READ);
//    $output = "return \n" . date("Y-m-d H:i:s");
//    socket_write($socket_new, $output, strlen($output));
//
//} while (true);


$commonProtocol = getprotobyname("tcp");
$socket = socket_create(AF_INET, SOCK_STREAM, $commonProtocol);
socket_bind($socket, '127.0.0.1', 1337); //socket_bind() 把socket绑定在一个IP地址和端口上
socket_listen($socket, 5);
socket_set_block($socket);
$buffer = "NO DATA";
while (true) {
    // Accept any connections coming in on this socket
    $connection = socket_accept($socket);//socket_accept() 接受一个Socket连接
    printf("Socket connected\r\n " . $connection . "\r\n");
    // Check to see if there is anything in the buffer
    if ($buffer != "") {
        printf("Something is in the buffer...sending data...\r\n");
        socket_write($connection, $buffer . "\r\n"); //socket_write() 写数据到socket缓存
        printf("Wrote to socket\r\n");
    } else {
        printf("No Data in the buffer\r\n");
    }
    // Get the input
    while ($data = socket_read($connection, 1024, PHP_NORMAL_READ)) {//socket_read() 读取指定长度的数据
        $buffer = $data;
        socket_write($connection, "Information Received\r\n");
        printf("Buffer: " . $buffer . "\r\n");
    }
    socket_close($connection); //socket_close() 关闭一个socket资源
    printf("Closed the socket\r\n\r\n");
}