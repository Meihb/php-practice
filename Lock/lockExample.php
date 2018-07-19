<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/2/28
 * Time: 15:14
 */

/**
 * Class MyLock
 *
 */
class MyLock
{
    const LOCK_TYPE_DB = 'MysqlLock';
    const LOCK_TYPE_FILE = 'FileLock';
    const LOCK_TYPE_MEMCACHE = 'MemcacheLock';
    const LOCK_TYPE_REDIS = 'RedisLock';


    private $_lock = null;
    private static $_supportLocks = array('FileLock', 'MysqlLock', 'MemcacheLock', 'redisLock');

    public function __construct($type, $options = array())
    {
        if (false == empty($type)) {
            $this->createLock($type, $options);
        }
    }

    private function createLock($type, $options = array())
    {
        if (false == in_array($type, self::$_supportLocks)) {
            throw new Exception("not support lock of ${type}");
        }
        $this->_lock = new $type($options);
    }

    public function getLock($key, $timeout = ILock::EXPIRE)
    {
        if (false == $this->_lock instanceof ILock) {
            throw new Exception('false == $this->_lock instanceof ILock');
        }
        return $this->_lock->getLock($key, $timeout);
    }

    public function releaseLock($key)
    {
        if (false == $this->_lock instanceof ILock) {
            throw new Exception('false == $this->_lock instanceof ILock');
        }
        return $this->_lock->releaseLock($key);
    }
}

interface ILock
{
    const EXPIRE = 10;

    public function getLock($key, $timeout = self::EXPIRE);

    public function releaseLock($key);
}

class FileLock implements ILock
{
    private $fp;
    private $_single;

    public function __construct($options)
    {
        if (isset($options['path']) && is_dir($options['path'])) {
            $this->_lockpath = $options['path'] . '/';
        } else {
            $this->_lockpath = '/opt/data/tmp_log/';
        }
        $this->_single = isset($options['single']) ? $options['single'] : false;
    }

    public function getLock($key, $timeout = self::lock_expire_time)
    {
        $startTime = time();
        $file = md5(__FILE__ . $key);
        $this->fp = fopen($this->_lockpath . $file . ".lock", "w+");
        if ($this->_single) {
            $op = LOCK_EX + LOCK_NB;
        } else {
            $op = LOCK_EX;
        }
        /**
         * operation
         * 1.LOCK_SH 取得共享锁（读取的程序） defined as 1
         * 2.LOCK_EX 取得独占锁（写入的程序） defined as 2
         * 3.LOCK_UN 释放锁定 （无论共享或独占） defined as 3
         * 4.LOCK_NB 在flock()锁定时不阻塞   defined as 4
         */
        if (!flock($this->fp, $op, $a)) {
            throw new Exception('failed');
        }
        return true;
    }

    public function releaseLock($key)
    {
        flock($this->fp, LOCK_UN);
        fclose($this->fp);
    }
}

class MysqlLock implements ILock
{

    private $_mysql;
    private $_default = [
        'host' => '127.0.0.1',
        'port' => '3306',
        'user' => 'dwts',
        'pwd' => '12121992',
        'database' => 'dwts',
    ];

    public function __construct(array $options = [])
    {
        $this->connect($options);
    }

    public function connect(array $options = [])
    {
        $DB = @mysqli_connect(
            isset($options['host']) ?: $this->_default['host'],
            isset($options['user']) ?: $this->_default['user'],
            isset($options['pwd']) ?: $this->_default['pwd'],
            isset($options['database']) ?: $this->_default['database'],
            isset($options['port']) ?: $this->_default['port']
        );
        $DB->query("set names 'utf8';");
        $this->_mysql = $DB;

        return true;
    }

    public function getLock($key, $timeout = self::EXPIRE)
    {

        $res = $this->_mysql->query("SELECT GET_LOCK('{$key}',$timeout) as lock_flag")->fetch_array();
//        var_dump($res);
        return $res['lock_flag'];
    }

    public function releaseLock($key)
    {
        $res = $this->_mysql->query("SELECT RELEASE_LOCK('{$key}')");
        return $res;
    }
}

class RedisLockV1 implements ILock
{
    private $redis;
    private $_config;
    private $_keyPrefix;

    public function __construct($config, $keyPrefix = 'RedisLock')
    {
        $this->_config = $config;
        $this->_keyPrefix = $keyPrefix;
        try {
            $this->redis = $this->_connect();
        } catch (Exception $e) {
            return false;
        }
        return true;

    }


    /**
     * @return bool|Redis
     * @throws Exception
     */
    private function _connect()
    {
        try {
            $redis = new Redis();
            $redis->connect($this->_config['host'], $this->_config['port'], $this->_config['timeout'], $this->_config['reserved'], $this->_config['retry_interval']);
            if (empty($this->_config['auth'])) {
                $redis->auth($this->_config['auth']);
            }
            $redis->select($this->_config['index']);
        } catch (RedisException $e) {
            throw new Exception($e->getMessage());
        }
        return $redis;

    }

    public function getLock($key, $timeout = self::EXPIRE)
    {
        $key = $this->_keyPrefix . $key . 'lock';
        $this->redis->set($key, 'locked', time() + $timeout);
    }

    public function releaseLock($key)
    {
        // TODO: Implement releaseLock() method.
    }

}

class testMyNanme
{
    static function changeName()
    {
        $DB = new mysqli('127.0.0.1', 'dwts', '12121992', 'dwts', '3306');
        $DB->query("set names 'utf8';");

        $DB->query('UPDATE  ');

    }
}
