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

$channel->queue_declare("new_rfc_self_queue", false, false, false, false, false, ['x-expirations', 1800000]);
$channel->queue_declare("new_rfc_wait_queue", false, false, false, false, false, ['x-expirations', 1800000]);

if (!isset($argv[0]) || empty($argv[0])) {
    fwrite(STDERR, "Missing fib num,Usage:$argv[0] [number]");
    exit(1);
}
$msg = new \PhpAmqpLib\Message\AMQPMessage((int)$argv[0]);

$channel->basic_publish($msg, "", "new_rfc_self_queue");

$channel->basic_consume("new_rfc_wait_queue", "", false, false, false, false,
    function ($msg) {
        echo "[X] get message", $msg->body, PHP_EOL;
        
    }
);


