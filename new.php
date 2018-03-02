<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-26
 * Time: 11:29
 */
$session_name = session_name();
//获取sessIonID
$session_id = $_GET[$session_name];
var_dump($session_id);
//使用session_id获取session
$result = session_id($session_id);
var_dump($result);
session_start();
var_dump($_SESSION);
