<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-17
 * Time: 17:03
 */

//$mem = new Memcache();
//$mem->pconnect('localhost',11211);
//$mem->set('key', 'mehb!');
//$val = $mem->get('key');
//echo $val;

//$mem = new Memcache();
//$mem->pconnect('localhost',11211);
//$mem->set('key', 'mehb!');
//$val = $mem->get('key');
//echo $val;

$memcached = new Memcache();

//分布式服务器
$memcached->addServer('127.0.0.1',11211,true,1,1,15,true);
$memcached->addServer('127.0.0.1',11212,true,1,1,15,true);

$memcached->set('distribute','meihb',0,150);

$value = $memcached->get('distribute');
var_dump($value);

