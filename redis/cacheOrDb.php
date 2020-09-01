<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/8/28
 * Time: 12:05
 */


/**
 * @param Redis $redis
 * @param $cacheName
 * @param callable $db
 * @param callable $expire
 * @param $defaultValue
 * @param int $depth
 * @return mixed
 */
function getCacheOrDb(Redis $redis, $cacheName, callable $db, callable $expire, $defaultValue = -1, $depth = 0)
{
//    echo "depth:{$depth}<br>";
    $ret = $defaultValue;
    if ($depth >= 4) {
        return $ret;
    }
    $redis_value = $redis->get($cacheName);
//    echo "redis_value:$redis_value<br>";
    if (empty($redis_value)) {//无缓存
        $mutex_key = $cacheName . "_MUTEX";
        $mutex_value = time();
        if ($redis->set($mutex_key, $mutex_value, ['nx', 'ex' => 75])) {//防止缓存击穿
            $db_value = $db();
//            sleep(1);//模拟并发,增加观察窗口
            if (!empty($db_value)) {
                $redis->set($cacheName, json_encode($db_value), ['ex' => $expire()]);//缓存db查询值
                $ret = $db_value;
            } else {
                $redis->set($cacheName, $defaultValue, ['ex' => $expire()]);//db查询空缓存默认值防止缓存穿透
                $ret = $defaultValue;
            }
            if ($redis->get($mutex_key) == $mutex_value) {
                $redis->del($mutex_key);//删除 排它锁
            }
        } else {
            sleep(1);
            $ret = getCacheOrDb($redis, $cacheName, $db, $expire, $defaultValue, $depth + 1);
        }

    } else {
        $ret = json_decode($redis_value, true);
    }
    return $ret;
}


/*
 * 关于global $variable的猜想
 * 全局变量 可以通过关键字global被引入到function中,但是如果在函数中创建匿名函数想要获取外部函数的变量,则需要通过use
 */