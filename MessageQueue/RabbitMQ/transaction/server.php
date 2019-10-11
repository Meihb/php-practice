<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/10
 * Time: 15:43
 */
require_once "../connection.php";

use PhpAmqpLib\Wire\AMQPTable;
use PhpAmqpLib\Message\AMQPMessage;

$connection = getConn();
$channel = $connection->channel();

$channel->exchange_declare("confirm_test", "direct", false, false, true);

$channel->queue_declare("confirm_queue", false, false, false, true);

$channel->queue_bind("confirm_queue", "confirm_test", "test");

echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

$callback = function ($msg) {
    print_r($msg->delivery_info['channel']->callbacks);
    echo " [x] Received ", $msg->body, "\n";
    echo " [x] Done", "\n";
    $ack = (strpos($msg->body, 'ack'));
    echo " [x] ack is  " . var_dump($ack), "\n";
    if ($ack >= 0) {
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);//手动消费确认
    } else {
        $msg->delivery_info['channel']->basic_reject($msg->delivery_info['delivery_tag'], true);//手动消费否决
    }
};
$channel->basic_consume("confirm_queue", '', false, true, false, false,$callback );

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

