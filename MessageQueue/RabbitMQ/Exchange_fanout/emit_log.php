<?php
/**
 * Created by PhpStorm.
 * User: 12538
 * Date: 2019-10-7
 * Time: 16:43
 */
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

//申明扇形exchange
$channel->exchange_declare('logs', 'fanout', false, false, false);
$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "info: Hello World!";
}
$msg = new AMQPMessage($data);
$channel->basic_publish($msg, 'logs');
echo ' [x] Sent ', $data, "\n";
$channel->close();
$connection->close();