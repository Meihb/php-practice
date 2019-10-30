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
    function ($AMQPMessage) {
        //此message虽也是AMQPMessage,但是好多方法 并不存在
        var_dump($AMQPMessage);
        var_dump($AMQPMessage->get("timestamp"));
        echo "Message acked with content " . $AMQPMessage->body . PHP_EOL;
    }
);
$channel->set_nack_handler(
    function ($AMQPMessage) {
        var_dump($AMQPMessage);
        echo "Message nacked with content " . $AMQPMessage->body . PHP_EOL;
    }
);
$channel->set_return_listener(
    function ($reply_code,
              $reply_text,
              $exchange,
              $routing_key,
              $message) {
        var_dump(func_get_args());
        echo "Message returned with content " . $message->body . PHP_EOL;
        //意思是如果路由失败,会调用一次basic_return再调用一次ack? why？？？
        /* 根据stackoverflow上面的回答
        That snippet is talking about AMQP 0-9-1. RabbitMQ offers extensions to that protocol, one of which is Publisher Confirms.
        Publisher confirms are not part of the AMQP 0-9-1 standard itself.
        If you get an "OK", or basic.ack, back then that is a Publisher Confirm.
        Once you have received that bacic.ack it means that the broker definitely received the message. But you could still "lose" the message at this point. If there are no
        queues bound to that exchange or there are no queues with a binding that matches the message, then the broker will discard the message.
        So although you received a basic.ack, the message is now lost.So if you really want some guarantees you should use Publisher Confirms coupled with setting the Mandatory
        flag on the message. If you use this flag, then you will receive a basic.return (followed by a basic.ack) response from the broker if it received the message but could not route it to an exchange. Your application can then take appropriate measures.
        意思是只要非nack那么ack一定会被调用,ack保证了broker确实收到了publisher的信息,但是此时数据依旧可能会丢失,即路由无法找到对应队列,那么在mandatory=true的情况下
        thus ack/nack才是一对,return_listener和前面两个不是一个过程
        */
    }
);
if (!(isset($argv[1]) && !empty($argv[1]))) {
    file_put_contents("php://stderr", "Usage:$argc[1] [message]");
    exit(1);
}
$data = date("Y-m-d H:i:s") . " send: " . implode(' ', array_slice($argv, 1));

//看起来每一个 没有被绑定到交换机的队列都可以通过默认的""直连交换机用队列名作键名访问
$channel->queue_declare("confirm_queue", false, false, false, true);


//看起来AMQPMESSAGE不支持自定义的propertity,其使用了array_intersect_key保证了只能是14个已定义属性
//basic_reject好像也无法中途改变message 的propertity的value
$msg = new AMQPMessage($data, ['correlation_id' => (string)2, 'timestamp' => time(), 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

/*
mandatory
    当mandatory标志位设置为true时，如果exchange根据自身类型和消息routeKey无法找到一个符合条件的queue，那么会调用basic.return方法将消息返回给生产者（Basic.Return + Content-Header
    + Content-Body）；当mandatory设置为false时，出现上述情形broker会直接将消息扔掉。
immediate 疑似被放弃
    当immediate标志位设置为true时，如果exchange在将消息路由到queue(s)时发现对于的queue上么有消费者，那么这条消息不会放入队列中。当与消息routeKey关联的所有queue（一个或者多个）
    都没有消费者时，该消息会通过basic.return方法返还给生产者。
概括来说，mandatory标志告诉服务器至少将该消息route到一个队列中，否则将消息返还给生产者；
immediate标志告诉服务器如果该消息关联的queue上有消费者，则马上将消息投递给它，如果所有queue都没有消费者，直接把消息返还给生产者，不用将消息入队列等待消费者了
*/
$channel->basic_publish($msg, "", "confirm_queue", true);

echo " [x] Sent ", $data, "\n";
//阻塞等待消息确认
//$channel->wait_for_pending_acks();
//looks like there`s another basic.return
$channel->wait_for_pending_acks_returns();


$channel->close();
$connection->close();

