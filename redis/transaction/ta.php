<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/29
 * Time: 16:00
 */
$redis = new Redis();
$redis->connect('127.0.0.1');

/*命令	作用	                返回值
watch	监视一个或多个key	总是OK
multi	声明事务开始,后续命令将排队按顺序等待exec执行	总是OK
exec	顺序执行multi之后的命令，如果multi之前使用watch命令监视的键的值发生变化，执行将失败	执行成功时返回数组包含每个命令执行结果，失败时原生命令返回null，php-redis扩展方法返回false
discard	取消事务	总是OK
unwatch	取消watch监视，如果watch监视之后执行了exec或discard，会自动取消监视，不必再unwatch	总是OK

 在 事务 执行 之前,一旦监视到key被改动, 事务 && 执行关键词
*/
//监听,乐观锁！
{
    $redis->watch('num');

//开启事务块
    $redis->multi();;
    $redis->set('name', 'mhb' . date("Y-m-d H:i:s"));
    sleep(5);

//事务执行
    $redis->exec();

//取消事务,回滚
//$redis->discard();


//取消监听
    $redis->unwatch();
}

/*
 * 考虑一下两种Mutlti内执行错误导致被动回滚的问题
 *
 * 例1
 * multi()->set('key1','value1')->set('key2','value2')->incr("key1")->set('key2','value22')->exec
 *  很明显,incr了一个string类型,属于命令格式正确而数据类型不符合
 *  那么,结果如何呢 get key1=value1 ;get key2=value22
 *  即是说,如果命令格式正确而数据类型不符,在此错误之前之后的所有操作依然会被exec成功;这一点和数据库的回滚不同
 *
 * 例2
 * multi; set key1 value1;set key2 ;set key2 value2;exec
 * 结果 key1=nil,key2=nil
 * 此处属于命令格式已经错误,那么在命令格式错误之处redis便已经报错(而上例incr指令依旧显示QUEUED)，等到开始执行exec时无论错误前后的指令都无法执行,直接报错
 *
 * 因此可以得出结论,multi中命令格式不报错则皆可以QUEUED成功,在exec中都可以执行,那些类型不符合的报错但不会影响整体,个体错误将无视
 * 这就是redis的事务回滚机制和数据库的回滚机制不同
 *
 */


