<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/26
 * Time: 11:46
 */
$redis = new Redis();
$redis->connect("118.25.41.135");
$redis->ping() or die('无法连接至redis');