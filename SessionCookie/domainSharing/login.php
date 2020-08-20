<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/8/14
 * Time: 14:14
 */

require_once "config.php";
$session_id = session_id();
echo "session_id:$session_id";
$_SESSION['name'] = 'user1';

setcookie( "TestCookie",  session_id(),  time() + 3600,  "/", ".practice.com" );