<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-27
 * Time: 9:54
 */

/***********简单应用*************/

//exec he execute区别,exec试行传参,execute执行对象的prepare sql
//PDO::exec执行一条SQL语句，并返回受影响的行数。此函数不会返回结果集合。
//PDO::query执行一条SQL语句，如果通过，则返回一个PDOStatement对象。PDO::query函数有个“非常好处”，就是可以直接遍历这个返回的记录集。
//PDO::excute 是PDO::query的预处理版本

try {
    $dsn = "mysql:host=localhost;dbname=dwts";
    $db = new PDO($dsn, 'root', '12121992', [PDO::ATTR_PERSISTENT => true]);//长连接
    //设置异常可捕获
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $db->setAttribute(PDO::ATTR_PERSISTENT,true);
    $db->exec("SET NAMES 'UTF8'");
//
//    $sql = "INSERT INTO tc0_log (name,content,ip,datetime)VALUES ('admin','插入一条数据','{$_SERVER['REMOTE_ADDR']}',now())";//{告诉php大括号的内容以变量处理}
//    $db->exec($sql);

    //使用预处理语句
//    $insert = $db->prepare(" INSERT INTO tc0_log (name,content,ip,datetime)VALUES (?,?,?,NOW())");
//
//    $insert->execute(['admin','插入一条记录11',"{$_SERVER['REMOTE_ADDR']}"]);
//    $insert->execute(['admin','插入一条记录12',"{$_SERVER['REMOTE_ADDR']}",8,9]);
    //异常
    $sql = "SELECT name,content,ip,datetime FROM tc0_log";
    $query = $db->prepare($sql);
    $query->execute();
//    var_dump($query->fetchAll(PDO::FETCH_ASSOC));

    //参数绑定试验
    $id = 2;
    $id2 = 4;
    $sql = "EXPLAIN SELECT  id FROM tc0_log WHERE id<? OR id> ?";
    $prepare = $db->prepare($sql);
    $prepare->bindParam(1, $id, PDO::PARAM_INT);
    $prepare->bindParam(2, $id2, PDO::PARAM_INT);
    $prepare->execute();
//    print_r($prepare->fetchAll());
    //事务
//    $db->beginTransaction();
//    $db->exec("INSERT INTO tc0_log (name,content,ip,datetime)VALUES ('admin','插入一条数据','{$_SERVER['REMOTE_ADDR']}',now())");
//    $db->exec("INSERT INTO XXX");
//    $db->commit();


    /*
     * 存储过程 procedure
     */
    //存储过程,存储过程的 数据类型在参数名之后, declare 参数 数据类型,包括in out 参数名同样如此申明
    //declare是过程变量,set @是会话变量否则与declare相同,且set好像不可以加参数类型
    $procedure = " 
    DROP PROCEDURE  IF EXISTS mytest1 ;
    CREATE PROCEDURE mytest1(IN a int ,IN b int)
    BEGIN
    set s=a+b;
    select s;
    END
    ";
    $exec=$db->exec($procedure);//貌似用PDO::query就会错误
//    print_r($exec->fetchAll());
    $sql = "CALL mytest1(2,3)";
    $exec = $db->query($sql);
    print_r($exec->fetchAll());

    /*
     * 时间调度 job ,创建或更新event 当 event_schedule=1时(show variables like '%sche%')才会执行,否则不会自动执行,
     * 据传为0时当前enable的活动也不会停止，但是我测试下来 every的任务是会关闭的
     * set global event_scheduler=1
     */

} catch (PDOException $PDOException) {

    echo 'error' . "\r\n";
    echo $PDOException->getMessage();
}


