<?php
/**
 * Created by PhpStorm.
 * User: 12538
 * Date: 2019-10-8
 * Time: 22:13
 */
require_once "../connection.php";
$connection = getConn();

$channel = $connection->channel();

//申明一个direct类型的交换机
$channel->exchange_declare("direct_logs", "direct", false, false, true);

//创建一个临时队列
list($queue_name,) = $channel->queue_declare("", false, false, true, true);

$severities = array_slice($argv, 1);
if (empty($severities)) {
    file_put_contents('php://stderr', "Usage:$argv[0] [info] [warning] [error]\n");
    exit(1);
}
print_r($severities);
foreach ($severities as $severity) {
    //绑定到交换机,键名不同 至同一个队列
    $channel->queue_bind($queue_name, 'direct_logs', $severity);
}

echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();