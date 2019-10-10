<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/10
 * Time: 14:38
 */

require_once "../connection.php";

$connection = getConn();
$channel = $connection->channel();