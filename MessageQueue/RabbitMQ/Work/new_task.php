<?php
/**
 * Created by PhpStorm.
 * User: 12538
 * Date: 2019-10-5
 * Time: 15:11
 */

chdir(dirname(__FILE__));
$config = require_once "../config.php";

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
require_once $config['vendor']['path'] . '/autoload.php';

$connection = new AMQPStreamConnection($config['rabbitmq']['host'],
    $config['rabbitmq']['port'],
    $config['rabbitmq']['login'],
    $config['rabbitmq']['password'],
    $config['rabbitmq']['vhost']
);
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = "Hello World!";
$msg = new AMQPMessage($data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)//持久化消息
);

$channel->basic_publish($msg, '', 'task_queue');

echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();

