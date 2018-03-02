<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-18
 * Time: 11:13
 */

function createCache() {
    $arr = array (array ("host" => "127.0.0.1", "port" => 11211, "weight" => 20 ), array ("host" => "127.0.0.1", "port" => 11212, "weight" => 80 ) );
    $cache = new memcache ();
    foreach ( $arr as $ele ) {
        $cache->addServer ( $ele ["host"], $ele ["port"], true, $ele ["weight"], 1 );
    }
    return $cache;
}
$cache = createCache ();

for($i = 0; $i < 10; $i ++) {
    $val = $cache->get ( $i );
    if (false === $val) {
        echo "缓存获取失败";
    } else {
        echo "缓存获取成功:,key:$val,value:$val";
    }
    echo "<br/>";
}
$cache->close ();