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
//声明两个队列
$channel->exchange_declare('delay_exchange', 'direct', false, false, false);
$channel->exchange_declare('cache_exchange', 'direct', false, false, false);

$table = new AMQPTable();
//死信交换机
$table->set('x-dead-letter-exchange', 'delay_exchange');//****很关键  表示过期后由哪个exchange处理
//死信交换机 键值
$table->set('x-dead-letter-routing-key', 'delay_exchange');//****很关键  表示过期后由哪个exchange处理
$table->set('x-message-ttl',15000);  //存活时长   下面的过期时间不能超过,单位ms

//缓存队列
$channel->queue_declare('cache_queue', false, true, false, false, false, $table);
$channel->queue_bind('cache_queue', 'cache_exchange', 'cache_exchange');

//死信队列
$channel->queue_declare('delay_queue', false, true, false, false, false);
$channel->queue_bind('delay_queue', 'delay_exchange', 'delay_exchange');

$ttl =

$msg = new AMQPMessage('Hello World' . date('Y-m-d H:i:s'), array(
    'expiration' => intval(10000),
    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT

));
//发布到缓存队列
$channel->basic_publish($msg, 'cache_exchange', 'cache_exchange');
echo date('Y-m-d H:i:s') . " [x] Sent 'Hello World!' " . PHP_EOL;

$channel->close();

