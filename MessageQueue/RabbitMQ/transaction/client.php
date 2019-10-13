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
    function ( $AMQPMessage) {
        var_dump(func_get_args());
        var_dump($AMQPMessage);
        echo "Message acked with content " . $AMQPMessage->body . PHP_EOL;
    }
);
$channel->set_nack_handler(
    function ( $AMQPMessage) {
        var_dump(func_get_args());
        var_dump($AMQPMessage);
        echo "Message nacked with content " . $AMQPMessage->body . PHP_EOL;
    }
);
$channel->set_return_listener(
    function ( $AMQPMessage) {
        var_dump(func_get_args());
        var_dump($AMQPMessage);
        echo "Message returned with content " . $AMQPMessage->body . PHP_EOL;
    }
);
if (!(isset($argv[1]) && !empty($argv[1]))) {
    file_put_contents("php://stderr", "Usage:$argc[1] [message]");
    exit(1);
}
$data = date("Y-m-d H:i:s") . " send: " . implode(' ', array_slice($argv, 1));

//看起来每一个 没有被绑定到交换机的队列都可以通过默认的""直连交换机用队列名作键名访问
$channel->queue_declare("confirm_queue", false, false, false, true);


$msg = new AMQPMessage($data,['mytype'=>"myinfo"]);

/*
mandatory
    当mandatory标志位设置为true时，如果exchange根据自身类型和消息routeKey无法找到一个符合条件的queue，那么会调用basic.return方法将消息返回给生产者（Basic.Return + Content-Header
    + Content-Body）；当mandatory设置为false时，出现上述情形broker会直接将消息扔掉。
immediate
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

