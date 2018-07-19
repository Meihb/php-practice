<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/3/2
 * Time: 10:37
 */

include_once "./lockExample.php";
$key = 036050;
/*
$FileLock = new MyLock(
    "FileLock",
    []
);

if ($FileLock->getLock($key)) {//获取锁
    print "Got it";
    $FileLock->releaseLock($key);
}
*/
//测试mysql
$MysqlLock = new MyLock(
    'MysqlLock',
    []
);
if ($MysqlLock->getLock($key, 3)==1) {
    echo 'get lock';
} else {
    echo 'fail to get lock';
}