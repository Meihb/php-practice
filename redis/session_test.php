<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-23
 * Time: 14:40
 */

ini_set("session.save_handler", "redis");
ini_set("session.save_path", "tcp://127.0.0.1:6379");

session_start();
ob_start();
$_SESSION["name"] = 'sss';
var_dump($_SESSION);
//存入session
$_SESSION['class'] = array('name' => 'toefl', 'num' => date("Y-m-d H:i:s"));
var_dump($_SESSION);
/*
//检查session_id
echo 'session_id:' . session_id() . '<br/>';

//redis存入的session（redis用session_id作为key,以string的形式存储）
echo 'redis_session:' . $redis->get('PHPREDIS_SESSION:' . session_id()) . '<br/>';

//php获取session值
echo 'php_session:' . json_encode($_SESSION['class']);
*/
//连接redis
$redis = new Redis() or die("fail to make instance of Redis");
$redis->connect("118.25.41.135", 6379) or die('fail to connect to redis,erro:' . $redis->getLastError());

//var_dump($redis->ping());
$redis->select(15);


ob_clean();
//OBJECT
/*
 * OBJECT subcommand [arguments [arguments]]
OBJECT命令允许从内部察看给定key的Redis对象。

它通常用在除错(debugging)或者了解为了节省空间而对key使用特殊编码的情况。
当将Redis用作缓存程序时，你也可以通过OBJECT命令中的信息，决定key的驱逐策略(eviction policies)。
OBJECT命令有多个子命令：

OBJECT REFCOUNT <key>返回给定key引用所储存的值的次数。此命令主要用于除错。
OBJECT ENCODING <key>返回给定key锁储存的值所使用的内部表示(representation)。
OBJECT IDLETIME <key>返回给定key自储存以来的空转时间(idle， 没有被读取也没有被写入)，以秒为单位。
对象可以以多种方式编码：
字符串可以被编码为raw(一般字符串)或int(用字符串表示64位数字是为了节约空间)。
列表可以被编码为ziplist或linkedlist。ziplist是为节约大小较小的列表空间而作的特殊表示。
集合可以被编码为intset或者hashtable。intset是只储存数字的小集合的特殊表示。
哈希表可以编码为zipmap或者hashtable。zipmap是小哈希表的特殊表示。
有序集合可以被编码为ziplist或者skiplist格式。ziplist用于表示小的有序集合，而skiplist则用于表示任何大小的有序集合。
假如你做了什么让Redis没办法再使用节省空间的编码时(比如将一个只有1个元素的集合扩展为一个有100万个元素的集合)，特殊编码类型(specially encoded types)会自动转换成通用类型(general type)。
 */
/*
$redis->set('game', 'wow');
var_dump($redis->object("refcount", 'game'));//一个引用
sleep(3);
var_dump($redis->object("idletime", 'game'));//空转期,未被读取或写入的时间
echo $redis->get("game");
echo $redis->object('idletime', "game");
var_dump($redis->object("encoding", "game"));
$redis->set('phone', 15820123123);//大的数字也被编码为字符串
var_dump($redis->object("encoding", 'phone'));
$redis->set('age', 20);
var_dump($redis->object('encoding', 'age'));
*/

//PERSIST
/*
$redis->flushDB();
$redis->SET('time_to_say_goodbye', "886...");
$redis->EXPIRE('time_to_say_goodbye', 300);
sleep(3);
var_dump($redis->TTL('time_to_say_goodbye')); # (int) 297

$redis->PERSIST('time_to_say_goodbye');  # 移除生存时间
echo $redis->TTL('time_to_say_goodbye');  # 移除成功  //int(-1)
*/
//String
/*
$redis->flushdb();
var_dump($redis->exists("name"));
var_dump($redis->set("name", "mhb", ['ex' =>1, 'xx']));
var_dump($redis->get("name"));
sleep(1);
var_dump($redis->get("name"));
*/

//HASH
//$redis->flushDB();
//$redis->hSet('user1', 'name', 'mhb');
//$redis->hSet('user1', 'age', 26);
//$redis->lPush('user', 1, 2, 3, 4, 5, 6);
//var_dump($redis->lRange('user', 0, -1));
//$redis->hMSet('user_1', ['age' => 6, 'name' => 'u1', 'score' => 1, 'salary' => 2000]);
//$redis->hMSet('user_2', ['age' => 5, 'name' => 'u2', 'score' => 3, 'salary' => 2000]);
//$redis->hMSet('user_3', ['age' => 4, 'name' => 'u3', 'score' => 12, 'salary' => 2000]);
//$redis->hMSet('user_4', ['age' => 3, 'name' => 'u4', 'score' => 9, 'salary' => 2000]);
//$redis->hMSet('user_5', ['age' => 2, 'name' => 'u5', 'score' => 24, 'salary' => 2000]);
//$redis->hMSet('user_6', ['age' => 1, 'name' => 'u6', 'score' => 65, 'salary' => 2000]);

//get 默认是set? limit 是 start length(好坑,明明lrange是start end)
//$sortOption = ['by' => 'user_*->age', 'limit'=>[0,3],'get' => 'user_*->name', 'sort' => 'asc', 'alpha' => null, /*'store' => null*/];
//var_dump($redis->sort('user', $sortOption));
//var_dump($redis->hGet('user1', 'gender'));
//var_dump($redis->hGetAll('user1'));
//var_dump($redis->hKeys('user1'));
//var_dump($redis->hVals('user1'));
//$redis->delete('user1');
//var_dump($redis->exists('user1'));

//LIST
//$redis->flushDB();
//$redis->lPush('mylist1', 1, 23, 4, 32, 42);
//var_dump($redis->lRange('mylist1', 0, -1));
//var_dump($redis->rpop('mylist1'));

//SET
$redis->flushDB();

