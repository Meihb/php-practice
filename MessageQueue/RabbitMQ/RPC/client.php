<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/9
 * Time: 15:23
 */

require_once "../connection.php";
$connection = getConn();


class FibonacciRpcClient
{
    private $connection;
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;

    public function __construct(PhpAmqpLib\Connection\AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
        list($this->callback_queue, ,) = $this->channel->queue_declare(
            "", false, false, true, false);
        $this->channel->basic_consume(
            $this->callback_queue, '', false, false, false, false,
            array($this, 'on_response'));
    }

    public function on_response($rep)
    {
        //鉴定关联id是否正确
        if ($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;
        }
    }

    public function call($n)
    {
        $this->response = null;
        $this->corr_id = uniqid();

        $msg = new \PhpAmqpLib\Message\AMQPMessage(
            (string)$n,
            array('correlation_id' => $this->corr_id,
                'reply_to' => $this->callback_queue)
        );
        $this->channel->basic_publish($msg, '', 'rpc_queue');
        while (!$this->response) {
            $this->channel->wait();
        }
        return intval($this->response);
    }
}

;

$fibonacci_rpc = new FibonacciRpcClient($connection);


if (!(isset($argv[1]) && !empty($argv[1]) && is_numeric($argv[1]) && $argv[1] > 0)) {
    file_put_contents("php://stderr", "Usage:$argv[0] [integer]");
    exit(1);
}
$response = $fibonacci_rpc->call($argv[1]);
echo " [.] Got ", $response, "\n";