<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/9
 * Time: 9:50
 */

require_once "../connection.php";
$connection = getConn();

$channel = $connection->channel();

$channel->exchange_declare("topic_logs", "topic", false, false, true);

$routing_key = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : "anoymous.info";

$data = implode(' ', array_slice($argv, 2));

$data = !empty($data) ? $data : "Hello World";

$msg = new \PhpAmqpLib\Message\AMQPMessage($data);

//你细寻思
$channel->basic_publish($msg, "topic_logs", $routing_key);

echo " [x] Sent ",$routing_key,':',$data," \n";

$channel->close();
$connection->close();