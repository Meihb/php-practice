<?php
/**
 * remote procedure call 远程过程调用
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/9
 * Time: 14:36
 */

require_once "../connection.php";
$connection = getConn();

$channel = $connection->channel();

$channel->queue_declare("rpc_queue", false, false, false, false);

function fib($n)
{
    if ($n == 0) return 0;
    if ($n == 1) return 1;
    return fib($n - 1) + fib($n - 2);
}

echo "[X] Awaiting RPC requests\n";

$callback = function ($req) {
//    print_r($req);
    $n = intval($req->body);
    echo " [.] fib(", $n, ")\n";

    $msg = new \PhpAmqpLib\Message\AMQPMessage(
        (string)fib($n),
        ['correlation_id' => $req->get('correlation_id')]//correlation关联,即获取关联id
    );

    //发布至回调队列
    $req->delivery_info['channel']->basic_publish(
        $msg, '', $req->get('reply_to')
    );
    //消费确认
    $req->delivery_info['channel']->basic_ack(
        $req->delivery_info['delivery_tag']
    );
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume("rpc_queue", '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
