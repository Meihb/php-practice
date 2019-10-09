<?php
/**
 * Created by PhpStorm.
 * User: 12538
 * Date: 2019-10-5
 * Time: 15:11
 */

chdir(dirname(__FILE__));
$config = require_once "../config.php";

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once $config['vendor']['path'] . '/autoload.php';

$connection = new AMQPStreamConnection($config['rabbitmq']['host'],
    $config['rabbitmq']['port'],
    $config['rabbitmq']['login'],
    $config['rabbitmq']['password'],
    $config['rabbitmq']['vhost']
);
$channel = $connection->channel();

//持久化queue
$channel->queue_declare('task_queue', false, true, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function ($msg) {
//    print_r($msg);
    echo " [x] Received ", $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done", "\n";
    $ack = (strpos($msg->body, 'nice'));
    echo " [x] ack is $ack " , "\n";
    if ($ack >= 0) {
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);//手动消费确认
    } else {
        $msg->delivery_info['channel']->basic_reject($msg->delivery_info['delivery_tag']);//手动消费否决
    }

    //如果设置了consume confirm但是在callback里面没有进行实质的确认,那么即会一直阻塞在(目前测试是这样的),尤其设置了qos,则此消费者无法接受新的信息
    //act false就会导致重新分配出去,但是我还是不太清楚其中缘由,貌似已经被分配过得将不会再分配
    //但是,如果完全不去手动确认,好像也没啥关系
};
//这告诉RabbitMQ不要在一个时间给一个消费者多个消息。或者，换句话说，在处理和确认以前的消息之前，不要向消费者发送新消息。相反，它将发送给下一个仍然不忙的消费者
$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>