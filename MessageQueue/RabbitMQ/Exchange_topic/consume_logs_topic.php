<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/9
 * Time: 10:14
 */

require_once "../connection.php";
$connection = getConn();

$channel = $connection->channel();

$channel->exchange_declare("topic_logs", "topic", false, false, true);

$routing_key = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : "anoymous.info";

list($queue_name,) = $channel->queue_declare("", false, false, true, true);

$binding_keys = array_slice($argv, 1);
if (empty($binding_keys)) {
    file_put_contents('php://stderr', "Usage: $argv[0] [binding_key]\n");
    exit(1);
}

foreach ($binding_keys as $binding_key) {
    //绑定队列至exchange
    $channel->queue_bind($queue_name, 'topic_logs', $binding_key);
}
echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);//手动消费确认
};

$channel->basic_consume($queue_name, "", false, false, false, false, $callback);//尝试一下不发送act试试

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();