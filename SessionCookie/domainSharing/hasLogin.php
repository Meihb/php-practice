<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/8/14
 * Time: 14:16
 */
require_once "config.php";

//$redis = new \Redis();
//$redis->connect("109.244.3.170", 6379);
//var_dump($redis->ping());

handleCors();
//var_dump($_COOKIE);

var_dump(session_id());
//session_id("4iris8soc9k7k3vl04n6lsnb82");
var_dump($_SESSION);
die();