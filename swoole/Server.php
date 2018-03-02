<?php

/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-24
 * Time: 16:34
 */
/*
class Server
{
    private $serv;

    public function __construct()
    {
        $this->serv = new swoole_server('127.0.0.1', 9501);
        $this->serv->set(
            [
                'worker_num' => 0,
                'daemonize' => false,
            ]
        );
        $this->serv->on('Start', array($this, 'onStart'));
        $this->serv->on('Connect', array($this, 'onConnect'));
        $this->serv->on('Receive', array($this, 'onReceive'));
        $this->serv->on('Close', array($this, 'onClose'));
        $this->serv->start();
    }

    public function onStart($serv)
    {
        echo "Start\n";
    }

    public function onConnect(Swoole_server $serv, $fd, $from_id)
    {
        echo "{$fd} has benn connected \n";
        $serv->send($fd, "Hello {$fd}!");
    }

    public  function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "Get Message From Client {$fd}:{$data}\n";
        $serv->send($fd, $data);
    }

    public  function onClose(swoole_server $serv, $fd, $from_id)
    {
        echo "Client {$fd} close connection\n";
    }

}
*/

class Server
{
    private $serv;

    public function __construct()
    {
        $this->serv = new Swoole\Server('127.0.0.1', 9511);

        //当启动一个Swoole应用时，一共会创建2 + n + m个进程，2为一个Master进程和一个Manager进程，其中n为Worker进程数。m为TaskWorker进程数。

        //默认如果不设置，swoole底层会根据当前机器有多少CPU核数，启动对应数量的Reactor线程和Worker进程。我机器为4核的。Worker为4。TaskWorker为0。

        //下面我来设置worker_num = 10。看下启动了多少个进程

        $this->serv->set([
            'worker_num' => 10,
//            'task_worker_num' => 2,
            'deamonize' => true,
        ]);

        //启动10个work，总共12个进程。
        /*
        ➜  Event git:(master) pstree |grep server.php
    |   \-+= 54172 yangyi php server.php  #Master进程
    |     \-+- 54173 yangyi php server.php  # Manager 进程
    |       |--- 54174 yangyi php server.php  #Work 进程
    |       |--- 54175 yangyi php server.php
    |       |--- 54176 yangyi php server.php
    |       |--- 54177 yangyi php server.php
    |       |--- 54178 yangyi php server.php
    |       |--- 54179 yangyi php server.php
    |       |--- 54180 yangyi php server.php
    |       |--- 54181 yangyi php server.php
    |       |--- 54182 yangyi php server.php
    |       \--- 54183 yangyi php server.php
         *
         */

        //增加新的监控的ip:post:mode
//        $this->serv->addlistener("::1", 9500, SWOOLE_SOCK_TCP);

        //监听事件
        /*
         *
         * - onStart
         * - onShutdown
         * - onWorkerStart
         * - onWorkerStop
         * - onTimer
         * - onConnect
         * - onReceive
         * - onClose
         * - onTask
         * - onFinish
         * - onPipeMessage
         * - onWorkerError
         * - onManagerStart
         * - onManagerStop
         */

        $this->serv->on('Start', array($this, 'onStart'));
        $this->serv->on('Connect', array($this, 'onConnect'));
        $this->serv->on('Receive', array($this, 'onReceive'));
        $this->serv->on('Close', array($this, 'onClose'));

        //master进程启动后, fork出Manager进程, 然后触发ManagerStart
        $this->serv->on('ManagerStart', function (\swoole_server $server) {
            echo "On manager start.\n";
        });

        //manager进程启动,启动work进程的时候调用 workid表示第几个id, 从0开始。
        $this->serv->on('WorkerStart', function ($serv, $workerId) {
            echo $workerId . "---\n";
        });

        //当一个work进程死掉后，会触发
        $this->serv->on('WorkerStop', function () {
            echo "--stop \n";
        });

        //启动
        $this->serv->start();
    }

    //启动server时候会触发。
    public function onStart($serv)
    {
        echo "Start\n";
    }

    //client连接成功后触发。
    public function onConnect(swoole_server $serv, $fd, $from_id)
    {
        var_dump($fd, $from_id);
        $a = $serv->send($fd, "Hello {$fd}!");
        //var_dump($a); //成功返回true
    }

    //接收client发过来的请求

    /**
     * @param swoole_server $serv
     * @param        int    $fd fd标识当前链接在该客户端在该服务开启之后的唯一序号
     * @param       int     $from_id from_id标识当前客户端连接在 connection_list中的 key号,换句话来说,其value标识一个当前处于连接状态得fd,但若是此fd断开连接,会复用此标识
     * @param       string  $data
     */
    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "worker id is {$serv->worker_id} ,fd is {$fd},from_id is {$from_id} \n";
        echo "Get Message From Client {$fd}:{$data}\n";
        //$serv->send($fd, $data);
        //关闭该work进程
        //$serv->stop();
        //宕机
        //$serv->shutdown();

        //主动关闭 客户端连接,也会触发onClose事件
        //$serv->close($fd);

        $serv->send($fd, $data);

        $list = $serv->connection_list();
        echo "list is " . print_r($list, 1) . "\n";
//           foreach ($list as $fd) {
//               $serv->send($fd, $data);
//           }
    }

    //客户端断开触发
    public function onClose(swoole_server $serv, $fd, $from_id)
    {
        echo "Client {$fd} close connection\n";
    }

}


//输出swoole的版本
echo swoole_version(); // 1.9.2

//输出本机iP
var_dump(swoole_get_local_ip());

/**
 * array(1) {
 * 'en4' =>
 * string(13) "172.16.71.149"
 * }
 */


// 启动服务器 Start the server
$server = new Server();