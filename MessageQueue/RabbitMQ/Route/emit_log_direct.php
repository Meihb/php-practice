<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/8
 * Time: 17:30
 */

require_once "../connection.php";
$connection = getConn();

$channel = $connection->channel();

//申明一个direct类型的交换机
$channel->exchange_declare("direct_logs", "direct", false, false, true);

$severity = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : "info";

$data = implode(' ', array_slice($argv, 2));

if (empty($data)) $data = "Hello World";

$msg = new \PhpAmqpLib\Message\AMQPMessage($data);

$channel->basic_publish($msg, 'direct_logs', $severity);

echo " [x] Sent ", $severity, ':', $data, " \n";

$channel->close();
$connection->close();