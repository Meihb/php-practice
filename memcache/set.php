<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-18
 * Time: 11:18
 */
function createCache()
{
    $arr=array(
        array("host"=>"127.0.0.1","port"=>11211,"weight"=>20), //127.0.0.1:11211的权重是20%
        array("host"=>"127.0.0.1","port"=>11212,"weight"=>80), //127.0.0.1:11212的权重是80%
    );
    $cache=new memcache;
    foreach ($arr as $ele )
    {
        //使用长连接，并且设置不同memcache服务器的权重，将memcache服务器添加到连接池
        $cache->addServer($ele["host"],$ele["port"],false,$ele["weight"]);
    }
    return $cache;
}
$cache = createCache ();
for($i=0;$i<10;$i++)
{
    //由于使用了分布式，所以这里不需要使用connect或者pconnect打开链接,set方法会调用memcache的分布式缓存分配算法，按照权重将缓存项缓存到连接池的某个服务器
    if($cache->set($i,$i,0,3600))
    {
        echo "缓存成功,key:$i,value:$i";
    }else
    {
        echo "缓存失败";
    }
    echo "<br/>";
}
$cache->close();