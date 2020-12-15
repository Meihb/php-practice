<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/12/11
 * Time: 9:47
 */


/*
 * twitter雪花算法 https://github.com/Leon2012/php-snowflake.git
 * attention 必须是64位php版本,因为这个算法需要使用64位运算,32位php确实会出现碰撞
 */

define('EPOCH', 1414213562373);
define('NUMWORKERBITS', 10);
define('NUMSEQUENCEBITS', 12);
define('MAXWORKERID', (-1 ^ (-1 << NUMWORKERBITS)));
define('MAXSEQUENCE', (-1 ^ (-1 << NUMSEQUENCEBITS)));

class Snowflake
{
    private $_lastTimestamp;
    private $_sequence = 0;
    private $_workerId = 1;

    public function __construct($workerId)
    {
        if (($workerId < 0) || ($workerId > MAXWORKERID)) {
            return null;
        }
        $this->workerId = $workerId;
    }

    public function next()
    {
        $ts = $this->timestamp();
        if ($ts == $this->_lastTimestamp) {
            $this->_sequence = ($this->_sequence + 1) & MAXSEQUENCE;
            if ($this->_sequence == 0) {
                $ts = $this->waitNextMilli($ts);
            }
        } else {
            $this->_sequence = 0;
        }

        if ($ts < $this->_lastTimestamp) {
            return 0;
        }

        $this->_lastTimestamp = $ts;

        return $this->pack();
    }

    private function pack()
    {
        return ($this->_lastTimestamp << (NUMWORKERBITS + NUMSEQUENCEBITS)) | ($this->_workerId << NUMSEQUENCEBITS) | $this->_sequence;
    }

    private function waitNextMilli($ts)
    {
        if ($ts = $this->_lastTimestamp) {
            sleep(0.1);
            $ts = $this->timestamp();
        }

        return $ts;
    }

    private function timestamp()
    {
        return $this->millitime() - EPOCH;
    }

    private function millitime()
    {
        $microtime = microtime();
        $comps = explode(' ', $microtime);
        // Note: Using a string here to prevent loss of precision
        // in case of "overflow" (PHP converts it to a double)
        return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
    }
}

//phpinfo();
//var_dump(12345678900);如果打印出来超过42亿的数字为Int,则证明为64位

error_reporting(E_ALL);
if (PHP_INT_SIZE == 4) {
    $bit = 32;
} else {
    $bit = 64;
}
//echo $bit . "<br>";
ini_set('max_execution_time', 0);
$snowflake = new Snowflake(1);
//echo $snowflake->next();
$redis = new  \Redis();
$redis->connect('127.0.0.1', '16379');
//var_dump($redis->ping());

$arr = [];
$key_name = 'test_sf';
$redis->expire($key_name, 300);

//$num = 0;
//for ($i = 0; $i < 100000; $i++) {
//    $num += $redis->sAdd($key_name, $snowflake->next());
//
//}
$code = $snowflake->next();
$redis->sAdd($key_name, $code);

$arr = ['num' => $code];
 echo json_encode($arr);


