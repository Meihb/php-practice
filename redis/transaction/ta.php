<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/29
 * Time: 16:00
 */
$redis = new Redis();
$redis->connect('127.0.0.1');

//监听,乐观锁！

$redis->watch('num');

//开启事务块
$redis->multi();
 ;
$redis->set('name', 'mhb'.date("Y-m-d H:i:s"));
sleep(5);

//事务执行
$redis->exec();

//取消事务,rollback?
//$redis->discard();


//取消监听
$redis->unwatch();


var_dump($redis->mget(['name','num']));