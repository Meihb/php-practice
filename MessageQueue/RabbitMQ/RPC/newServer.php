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

function fib($n)
{
    if ($n == 0) return 0;
    if ($n == 1) return 1;

    return fib($n - 1) + fib($n - 2);
}

$self_table = new \PhpAmqpLib\Wire\AMQPTable();
$self_table->set("x-expires", 1800000);
$channel->queue_declare("new_rfc_self_queue", false, false, false, true, false,$self_table);
echo "[X] Awaiting RPC requests\n";

$channel->basic_qos(null, 1, null);
$channel->basic_consume("new_rfc_self_queue", "", false, false, false, false, function ($msg) {

    echo "[X] get message ", $msg->body, PHP_EOL;
    $n = intval($msg->body);
    //ack
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    //reply_to
    $msg->delivery_info['channel']->basic_publish(
        new \PhpAmqpLib\Message\AMQPMessage((string)fib($n), ['correlation_id' => $msg->get("correlation_id")]),
        "",
        $msg->get("reply_to"));
});

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();