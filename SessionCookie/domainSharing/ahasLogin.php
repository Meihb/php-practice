<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/8/14
 * Time: 14:16
 */
require_once "config.php";

//var_dump($_COOKIE);
//if (!empty($_COOKIE['PHPSESSID'])) {
//    session_id($_COOKIE['PHPSESSID']);
//}
$inf = file_get_contents("http://practice.com:8080/SessionCookie/domainSharing/haslogin.php");
var_dump($inf);