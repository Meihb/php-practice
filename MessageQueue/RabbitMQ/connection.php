<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/8
 * Time: 16:09
 */
chdir(dirname(__FILE__));

date_default_timezone_set("Asia/Shanghai");
error_reporting(E_ALL);
$config = require_once "./config.php";
require_once $config['vendor']['path'] . '/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


//define("AMQP_DEBUG", true);
/**
 * @return AMQPStreamConnection
 */
function getConn()
{
    global $config;
    return $connection = new AMQPStreamConnection(
        $config['rabbitmq']['host'],
        $config['rabbitmq']['port'],
        $config['rabbitmq']['login'],
        $config['rabbitmq']['password'],
        $config['rabbitmq']['vhost']
    );

}


