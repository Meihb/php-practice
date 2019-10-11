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
$table->set('x-dead-letter-exchange', 'delay_exchange');//死信交换机 表示过期后由哪个exchange处理
$table->set('x-dead-letter-routing-key', 'delay_exchange');//死信交换机 键值  表示过期后以什么route_key交换
$table->set('x-message-ttl', 15000);  //存活时长   下面的过期时间不能超过,单位ms,若单独设置的时间超过此时间,则按照此时间计算


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

