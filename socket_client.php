<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-7
 * Time: 11:57
 */
header("Content-Type:text/html;   charset=gb2312");
//创建一个socket套接流
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
/****************设置socket连接选项，这两个步骤你可以省略*************/
//接收套接流的最大超时时间1秒，后面是微秒单位超时时间，设置为零，表示不管它
socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
//发送套接流的最大超时时间为6秒
socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 6, "usec" => 0));
/****************设置socket连接选项，这两个步骤你可以省略*************/

$host = '127.0.0.1';
$port = 1337;
$conn = socket_connect($socket, $host, $port);
if (!$conn) {
    echo "Could not connect to socket";
}
//var_dump('this is error',socket_last_error($socket));
//var_dump(socket_strerror(socket_last_error($socket)));

$message = 'Hello World';
if (socket_write($socket, $message, strlen($message)) == false) {
    echo 'fail to write' . socket_strerror(socket_last_error());

} else {
    echo 'client write success' . PHP_EOL;
    //读取服务端返回来的套接流信息


    while ($callback = socket_read($socket, 2048, PHP_BINARY_READ)) {
        var_dump($callback);
        echo 'server return message is:' . PHP_EOL . $callback;
        echo 'here';
    }
}
socket_close($socket);//工作完毕，关闭套接流


// Create the socket and connect
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//$connection = socket_connect($socket,'127.0.0.1', 1337);
//while($buffer = socket_read($socket, 1024, PHP_NORMAL_READ)) {
//    if($buffer == "NO DATA") {
//        echo("<p>NO DATA</p>");
//        break;
//    }else{
//        // Do something with the data in the buffer
//        echo("<p>Buffer Data: " . $buffer . "</p>");
//    }
//}
//echo("<p>Writing to Socket</p>");
// Write some test data to our socket
//if(!socket_write($socket, "SOME DATA\r\n")){
//    echo("<p>Write failed</p>");
//}
// Read any response from the socket phpernote.com
//while($buffer = socket_read($socket, 1024, PHP_NORMAL_READ)){
//    echo("<p>Data sent was: SOME DATA<br> Response was:" . $buffer . "</p>");
//}
//echo("<p>Done Reading from Socket</p>");