<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-25
 * Time: 11:17
 */


//class Client
//{
//    private $client;
//
//    public function __construct()
//    {
//        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
//    }
//
//    public function connect()
//    {
//        if (!$this->client->connect("127.0.0.1", 9501, 0)) {
//            echo "Error: {$this->client->errCode}[{$this->client->errCode}]\n";
//        }
//        fwrite(STDOUT, "请输入消息 Please input msg：");//STDOUT是cli模式下的常量
//        $msg = trim(fgets(STDIN));
//        $this->client->send($msg);
//        $message = $this->client->recv();
//        echo "Get Message From Server:{$message}\n";
//    }
//}


// sync 同步客户端
class client
{
    private $client;

    public function __construct()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP | SWOOLE_KEEP);
        $this->client->connect('127.0.0.1', 9511, 1);
    }

    public function connect()
    {
        //fwrite(STDOUT, "请输入消息：");
        //$msg = trim(fgets(STDIN));
        $msg = rand(1, 12);

        //发送给消息到服务端
        $this->client->send($msg);

        //接受服务端发来的信息
        $message = $this->client->recv();
        echo "Get Message From Server:{$message}\n";

        sleep(3);
        //关闭客户端
//        $this->client->close();

    }
}

$client = new Client();
$client->connect();

/**
 * 测试cli模式下传参方式
 */
//fwrite(STDOUT, 'ENTER YOUR NAME' . "\n");
//$name = trim(fgets(STDIN));
//fwrite(STDOUT, 'welcome ' . $name . "\n");
//
//var_dump($argv);

