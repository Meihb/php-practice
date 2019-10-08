<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/8
 * Time: 17:30
 */

require_once "../connection.php";
$connection = getConn();

$channel = $connection->channel();

$channel->exchange_declare("");