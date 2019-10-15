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

//给cache发送  使其过期然后定向到另一个
//申明缓存交换机
$channel->exchange_declare('cache_exchange', 'direct', false, false, false);
//申明死信交换机
$channel->exchange_declare('delay_exchange', 'direct', false, false, false);

$table = new AMQPTable();
/*DLX  Dead-letter-exchange
消息变成死信一向有一下几种情况：

消息被拒绝（basic.reject/ basic.nack）并且requeue=false
消息TTL过期（参考：RabbitMQ之TTL（Time-To-Live 过期时间））
队列达到最大长度
*/
$table->set('x-dead-letter-exchange', 'delay_exchange');//死信交换机 表示过期后由哪个exchange处理
$table->set('x-dead-letter-routing-key', 'delay_exchange');//死信交换机 键值  表示过期后以什么route_key交换
$table->set('x-message-ttl', 15000);  //存活时长 单位ms  队列ttl和消息ttl两者不同时取较小值,
//区别为:queue ttl的删除一旦消息过期,则立刻会被删除,因为过期消息一定在队列头部,而消息ttl由于不一致,一般在即将被消费时判断是否过期以待删除
$table->set('x-expires', 10000); //队列自身的超时时间,无consumer、未被重新declare、未调用过basic.get.但也不能保证即刻删除


$channel->queue_declare('cache_queue', false, true, false, false, false, $table);//缓存队列
$channel->queue_bind('cache_queue', 'cache_exchange', 'cache_exchange');//绑定缓存队列

//死信队列
$channel->queue_declare('delay_queue', false, true, false, false, false);
$channel->queue_bind('delay_queue', 'delay_exchange', 'delay_exchange');

$message = $argv[1] ?? null;
if (empty($message)) {
    file_put_contents("php://stderr", "Usage $argv[0] [message] [expiration] " . PHP_EOL);
    exit(1);
}
$ttl = $argv[2] ?? null;
if (empty($ttl)) {
    (file_put_contents("php://stderr", "Usage $argv[0] [message] [expiration]" . PHP_EOL));
    exit(1);

}

$msg = new AMQPMessage("$message  @ " . date('Y-m-d H:i:s'),
    [
        'expiration' => $ttl,
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
    ]


);
//发布到缓存队列
$channel->basic_publish($msg, 'cache_exchange', 'cache_exchange');
echo date('Y-m-d H:i:s') . " [x] Sent 'Hello World!' " . PHP_EOL;

$channel->close();

