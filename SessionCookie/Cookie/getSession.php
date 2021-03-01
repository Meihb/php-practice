<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2021/2/23
 * Time: 16:26
 */

session_start();

$_SESSION['user'] = 'mhb';

header("Location:" . "http://a.snda.com/SessionCookie/Cookie/test.html", false);
exit();