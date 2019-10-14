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


$channel->queue_declare("confirm_queue", false, false, false, true);


echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

$callback = function (AMQPMessage $msg) {
//    print_r($msg->delivery_info['channel']->callbacks);
    $timestamp = $msg->get('timestamp');
    var_dump(date("Y-m-d H:i:s", $timestamp));
//    $timestamp = $msg->set('timestamp');set开起来无法改变message的真是数值
    echo " [x] Received ", $msg->body, "\n";
    sleep(substr_count($msg->body, "."));
    $ack = strpos($msg->body, 'ack');
    if ($ack > 0 || time() >= $timestamp + 15) {
        echo " [x] ack is acked ", "\n";
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);//手动消费确认
    } else {
        echo " [x] ack is rejected ", "\n";
        //手动消费否决,在多开两个消费者的情况下,一边done,另一边就会获取,rather interesting!
        $msg->delivery_info['channel']->basic_reject($msg->delivery_info['delivery_tag'], true);
    }
    echo " [x] Done", "\n";
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume("confirm_queue", '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();

