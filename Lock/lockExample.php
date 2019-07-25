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
/*
 *     case "test_lk":
        $mysql_lock = new LockUtils("MysqlLock", $conn);
        $key = 1;
        if (!$mysql_lock->getLock($key, 10)) die("blocked");

        echo "get lock";
        $mysql_lock->releaseLock($key);


        break;

    case"test_lk2":
        $mysql_lock = new LockUtils("MysqlLock", $conn);
        $key = 1;
        if (!$mysql_lock->getLock($key, 3)) die("blocked");
        sleep(2);
        $mysql_lock->releaseLock($key);
        echo "get lock";
        break;
 */

class LockUtils
{
    const LOCK_TYPE_DB = 'MysqlLock';
    const LOCK_TYPE_FILE = 'FileLock';
//    const LOCK_TYPE_MEMCACHE = 'MemcacheLock';
    const LOCK_TYPE_REDIS = 'RedisLock';


    private $_lock = null;
//    private static $_supportLocks = array('FileLock', 'MysqlLock', 'MemcacheLock', 'redisLock');
    private static $_supportLocks = array('FileLock', 'MysqlLock', "RedisLock");

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

/**
 * 文件实现锁
 * Class FileLock
 */
class FileLock implements ILock
{
    private $fp;
    private $_single;
    private $_lockpath;

    public function __construct($options)
    {
        if (isset($options['path']) && is_dir($options['path'])) {
            $this->_lockpath = $options['path'] . '/';
        } else {
            $this->_lockpath = '/opt/data/tmp_log/';
        }
        $this->_single = isset($options['single']) ? $options['single'] : false;
    }

    public function getLock($key, $timeout = self::EXPIRE)
    {
        $startTime = time();
        $file = md5(__FILE__ . $key);
        $this->fp = fopen($this->_lockpath . $file . ".lock", "w+");
        if ($this->_single) {
            $op = LOCK_EX + LOCK_NB;//非阻塞
        } else {
            $op = LOCK_EX;//独占 阻塞
        }
        /**
         * operation
         * 1.LOCK_SH 取得共享锁（读取的程序） defined as 1
         * 2.LOCK_EX 取得独占锁（写入的程序） defined as 2
         * 3.LOCK_UN 释放锁定 （无论共享或独占） defined as 3
         * 4.LOCK_NB 在flock()锁定时不阻塞   defined as 4
         */

        do {
            $canWrite = flock($this->fp, $op);
            if (!$canWrite) {
                usleep(round(rand(1000) * 1000));
            }
        } while (!$canWrite && (time() - $startTime) < $timeout);
        if ($canWrite) {
            return true;
        } else {
            fclose($this->fp);
            return false;
        }
    }

    public function releaseLock($key)
    {
        flock($this->fp, LOCK_UN);
        fclose($this->fp);
    }
}

/**
 * mysql实现锁 阻塞锁
 * Class MysqlLock
 */
class MysqlLock implements ILock
{

    private $_conn;

    public function __construct($conn)
    {
        $this->_conn = $conn;
    }


    public function getLock($key, $timeout = self::EXPIRE)
    {

//        $res = $this->_mysql->query("SELECT GET_LOCK('{$key}',$timeout) as lock_flag")->fetch_array();
        $res = mysqli_query($this->_conn, "SELECT GET_LOCK('{$key}',$timeout) as lock_flag");
        $res = mysqli_fetch_array($res, MYSQLI_ASSOC);
        return $res['lock_flag'];
    }

    public function releaseLock($key)
    {
//        $res = $this->_mysql->query("SELECT RELEASE_LOCK('{$key}')");
        $res = mysqli_query($this->_conn, "SELECT RELEASE_LOCK('{$key}')");
        return $res;
    }
}

class RedisLock implements ILock
{
    private $redis;
    private $_config;
    private $_keyPrefix;
    private $_key_expire;
    private $_block;

    /**
     * RedisLockV1 constructor.
     * @param $redis Redis
     * @param $block
     * @param int $key_expire
     */
    public function __construct($options)
    {
        $this->_block = isset($options["block"]) ? (bool)$options['block'] : true;
        $this->redis = $options["redis"];
        $this->_key_expire = isset($options["key_expire"]) && (int)$options['key_expire'] >= 0 ? (int)$options["key_expire"] : 10;
//        $this->_config = $config;
//        $this->_keyPrefix = $keyPrefix;
//        try {
//            $this->redis = $this->_connect();
//        } catch (Exception $e) {
//            return false;
//        }
//        return true;

    }


    /**
     * @return bool|Redis
     * @throws Exception
     */
    private function _connect()
    {
        try {
            $this->redis = new Redis();
            $this->redis->connect($this->_config['host'], $this->_config['port'], $this->_config['timeout'], $this->_config['reserved'], $this->_config['retry_interval']);
            if (empty($this->_config['auth'])) {
                $this->redis->auth($this->_config['auth']);
            }
            $this->redis->select($this->_config['index']);
        } catch (RedisException $e) {
            throw new Exception($e->getMessage());
        }
        return $this->redis;

    }

    public function getLock($key, $timeout = self::EXPIRE)
    {
        $startTime = time();
        do {
            $canWrite = $this->redis->set($key, uniqid(), ['nx', 'ex' => $this->_key_expire]);
            if (!$canWrite) {
                usleep(round(rand(1000) * 1000));
            }
        } while (!$canWrite && (time() - $startTime) < $timeout);
        if (!$canWrite) {
            return false;
        }
        return true;
    }

    public function releaseLock($key)
    {
        return $this->redis->delete($key);
    }

}





