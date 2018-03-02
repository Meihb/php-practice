<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-23
 * Time: 14:31
 */
include_once "../redis/SessionManager.php";
new SessionManager();//这一步已经执行了read函数,即是说,session在start之后其实已经把session数据全部加载到内存中了,而非等请求才读取

$_SESSION['user12'] = 'Meihb';