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
        //创建临时队列,以作 回调队列,待消费者处理完之后,发送消息到此队列中,再被生产者消费
        list($this->callback_queue, ,) = $this->channel->queue_declare(
            "", false, false, true, false);
        //生产者作为消费者回调队列的消费者,消费方法是 on_response
        /*1. 直接回调非静态方法

call_user_func('my_callback_function'); 

2.类静态方法回调

all_user_func('MyClass::myCallbackMethod');

3.对象方法回调

call_user_func(array($obj, 'myCallbackMethod'));

 4: 调用父类静态方法
class A {
    public static function who() {
        echo "A\n";
    }
}

class B extends A {
    public static function who() {
        echo "B\n";
    }
}

call_user_func(array('B', 'parent::who')); // A
*/
        $this->channel->basic_consume(
            $this->callback_queue, '', false, false, false, false,
            [$this, 'on_response']
        );
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