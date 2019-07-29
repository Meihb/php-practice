<?php

/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-23
 * Time: 12:03
 */

//ini_set("session.save_handler", "redis");
//ini_set("session.save_path", "tcp://127.0.0.1:6379");

class SessionManager
{
    private $redis;
    private $sessionSavePath;
    private $sessionName = 'PHPSESSID_REDIS_';
    private $sessionExpiretime = 600;

    public function __construct()
    {
        $this->redis = new RedisIns();
        $this->redis->connect('127.0.0.1', 6379);

        session_module_name('user'); //session文件保存方式，这个是必须的！除非在Php.ini文件中设置了
        session_set_save_handler(
            [$this, 'open'],
            [$this, 'close'],
            [$this, 'read'],
            [$this, 'write'],
            [$this, 'destroy'],
            [$this, 'gc']
        );
        session_start();
    }

    public function open($path, $name)
    {
        echo 'it`s opening' . "</br>";
        return true;
    }

    public function close()
    {
        echo 'it`s closing' . "</br>";
        return true;

    }

    public function read($id)
    {
        echo 'it`s reading ' .$id. "</br>";
        $value = $this->redis->get($this->sessionName . $id);
        return $value;

    }

    public function write($id, $data)
    {
        echo 'it`s writing' . "</br>";
        if ($this->redis->set($this->sessionName . $id, $data)) {
            $this->redis->expire($this->sessionName . $id, $this->sessionExpiretime);
            return true;
        }
        return false;
    }

    public function destroy($id)
    {
        echo 'it`s destroing' . "</br>";
        $this->redis->delete($this->sessionName . $id);
        return true;
    }

    public function gc($maxlifetime)
    {
        echo 'it`s gcing' . "</br>";
        return true;
    }

    function __destruct()
    {
        session_write_close();
    }
}

class session//数据库
{
    private $db;
    private $lasttime = 3600;//超时时间：一个小时

    function __construct(&$db)
    {
        $this->db = &$db;
        session_module_name('user'); //session文件保存方式，这个是必须的！除非在Php.ini文件中设置了
        session_set_save_handler(
            array(&$this, 'open'), //在运行session_start()时执行
            array(&$this, 'close'), //在脚本执行完成或调用session_write_close() 或 session_destroy()时被执行,即在所有session操作完后被执行
            array(&$this, 'read'), //在运行session_start()时执行,因为在session_start时,会去read当前session数据
            array(&$this, 'write'), //此方法在脚本结束和使用session_write_close()强制提交SESSION数据时执行
            array(&$this, 'destroy'), //在运行session_destroy()时执行
            array(&$this, 'gc') //执行概率由session.gc_probability 和 session.gc_divisor的值决定,时机是在open,read之后,session_start会相继执行open,read和gc
        );
        session_start(); //这也是必须的，打开session，必须在session_set_save_handler后面执行
    }

    function unserializes($data_value)
    {
        $vars = preg_split(
            '/([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\|/',
            $data_value, -1, PREG_SPLIT_NO_EMPTY |
            PREG_SPLIT_DELIM_CAPTURE
        );
        for ($i = 0; isset($vars[$i]); $i++) {
            $result[$vars[$i++]] = unserialize($vars[$i]);
        }
        return $result;
    }

    function open($path, $name)
    {
        return true;
    }

    function close()
    {
        $this->gc($this->lasttime);
        return true;
    }

    function read($SessionKey)
    {
        $sql = "SELECT uid FROM sessions WHERE session_id = '" . $SessionKey . "' limit 1";
        $query = $this->db->query($sql);
        if ($row = $this->db->fetch_array($query)) {
            return $row['uid'];
        } else {
            return "";
        }
    }

    function write($SessionKey, $VArray)
    {
        require_once(MRoot . DIR_WS_CLASSES . 'db_mysql_class.php');
        $db1 = new DbCom();
        // make a connection to the database... now
        $db1->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
        $db1->query("set names utf8");
        $this->db = $db1;
        $SessionArray = addslashes($VArray);
        $data = $this->unserializes($VArray);
        $sql0 = "SELECT uid FROM sessions WHERE session_id = '" . $SessionKey . "' limit 1";
        $query0 = $this->db->query($sql0);
        if ($this->db->num_rows($query0) <= 0) {
            if (isset($data['webid']) && !empty($data['webid'])) {
                $this->db->query("insert into `sessions` set `session_id` = '$SessionKey',uid='" . $data['webid'] . "',last_visit='" . time() . "'");
            }
            return true;
        } else {
            /*$sql = "update `sessions` set ";
            if(isset($data['webid'])){
            $sql .= "uid = '".$data['webid']."', " ;
            }
            $sql.="`last_visit` = null "
                  . "where `session_id` = '$SessionKey'";
                              $this->db->query($sql); */
            return true;
        }
    }

    function destroy($SessionKey)
    {
        $this->db->query("delete from `sessions` where `session_id` = '$SessionKey'");
        return true;
    }

    function gc($lifetime)
    {
        $this->db->query("delete from `sessions` where unix_timestamp(now()) -`last_visit` > '" . $this->lasttime . "'");
        return true;
    }
}