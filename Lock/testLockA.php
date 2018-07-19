<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/3/2
 * Time: 10:37
 */

include_once "./lockExample.php";
$key = 036050;


/**
 * $FileLock = new MyLock(
 * "FileLock",
 * []
 * );
 * $key = 036050;
 * if ($FileLock->getLock($key)) {//获取锁
 * sleep(5);
 * $FileLock->releaseLock($key);
 * }
 * */

//测试mysql
$MysqlLock = new MyLock(
    'MysqlLock',
    []
);
if ($MysqlLock->getLock($key, 10)==1) {
    sleep(8);
    $MysqlLock->releaseLock($key);
} else {
    echo 'fail to getLock';
}
