<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/15
 * Time: 16:36
 */
require_once "../connection.php";

$Conn = getConn();
$channel = $Conn->channel();

function fib($n)
{
    if ($n == 0) return 0;
    if ($n == 1) return 1;

    return fib($n - 1) + fib($n - 2);
}

