<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-23
 * Time: 14:40
 */
ini_set("session.save_handler", "redis");
ini_set("session.save_path", "tcp://127.0.0.1:6379");

session_start();

//存入session
$_SESSION['class'] = array('name' => 'toefl', 'num' => date("Y-m-d H:i:s"));

//连接redis
$redis = new redis();
$redis->connect('127.0.0.1', 6379);

//检查session_id
echo 'session_id:' . session_id() . '<br/>';

//redis存入的session（redis用session_id作为key,以string的形式存储）
echo 'redis_session:' . $redis->get('PHPREDIS_SESSION:' . session_id()) . '<br/>';

//php获取session值
echo 'php_session:' . json_encode($_SESSION['class']);