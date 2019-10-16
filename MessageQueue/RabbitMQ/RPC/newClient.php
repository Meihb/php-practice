<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/15
 * Time: 16:36
 */
require_once "../connection.php";

$Conn = getConn();
$channel = $Conn->channel();

$channel_id = $channel->getChannelId();
$self_table = new \PhpAmqpLib\Wire\AMQPTable();
$self_table->set("x-expires", 1800000);
$channel->queue_declare("new_rfc_self_queue", false, false, false, true, false, $self_table);
$channel->queue_declare("new_rfc_reply_queue", false, false, false, false, false);

if (!isset($argv[1]) || empty($argv[1])) {
    fwrite(STDERR, "Missing fib num,Usage:$argv[0] [number]");
    exit(1);
}
$correlation_id = $channel_id . 'unique.' . uniqid();
$msg = new \PhpAmqpLib\Message\AMQPMessage(
    (string)$argv[1],
    ['correlation_id' => $correlation_id, 'reply_to' => 'new_rfc_reply_queue']
);


$channel->basic_publish($msg, "", "new_rfc_self_queue");

$RETURN = false;
$channel->basic_consume("new_rfc_reply_queue", "", false, false, false, false,
    function ($msg) use ($correlation_id) {
        global $RETURN;
        //use 只是继承父作用域的变量到本作用域内,global是申明为全局变量,即闭包内use的变量修改不影响父作用域,而global会
        echo "[X] get message", $msg->body, PHP_EOL;
//        var_dump($msg);
        if ($msg->get('correlation_id') == $correlation_id) {
            echo "[X] GOT RETURN :" . $msg->body;
            $msg->delivery_info["channel"]->basic_ack($msg->delivery_info["delivery_tag"]);
            $RETURN = true;
        } else {
            echo "[X] GOT SOMEONE ELSE ,REJECTED";
            $msg->delivery_info["channel"]->basic_reject($msg->delivery_info["delivery_tag"], true);
        }
    }
);

while (!$RETURN) {
    $channel->wait();
}
$channel->close();
$connection->close();

