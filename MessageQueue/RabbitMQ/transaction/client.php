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

$channel->confirm_select();//开启确认

$channel->set_ack_handler(
    function (AMQPMessage $AMQPMessage) {
        var_dump(func_get_args());
        var_dump($AMQPMessage);
        echo "Message acked with content " . $AMQPMessage->body . PHP_EOL;
    }
);
$channel->set_nack_handler(
    function (AMQPMessage $AMQPMessage) {
        var_dump(func_get_args());
        var_dump($AMQPMessage);
        echo "Message nacked with content " . $AMQPMessage->body . PHP_EOL;
    }
);

$channel->exchange_declare("confirm_test", "direct", false, false, true);
$channel->queue_declare("confirm_queue", false, false, false, true);

$channel->queue_bind("confirm_queue", "confirm_test", "test1");


$data = date("Y-m-d H:i:s")." send: ".implode(' ', array_slice($argv, 1));
if (empty($data)) $data = "Hello World!";
$msg = new AMQPMessage($data
);

$channel->basic_publish($msg, 'confirm_test',"test",true);
echo " [x] Sent ", $data, "\n";
//阻塞等待消息确认
$channel->wait_for_pending_acks();

$channel->close();
$connection->close();

