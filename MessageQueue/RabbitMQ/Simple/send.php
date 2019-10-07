<?php


chdir(dirname(__FILE__));
$config = require_once "../config.php";

require_once $config['vendor']['path'] . '/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(
    $config['rabbitmq']['host'],
    $config['rabbitmq']['port'],
    $config['rabbitmq']['login'],
    $config['rabbitmq']['password'],
    $config['rabbitmq']['vhost']
);
$channel = $connection->channel();

//发送方其实不需要设置队列， 不过对于持久化有关，建议执行该行
$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World!');
//第三个参数为queue的键名
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();
?>