<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/8/31
 * Time: 16:56
 */


class Database
{
    static $Instance;

    /**
     * @return mixed
     */
    public static function getInstance()
    {

        try {
            if (!static::$Instance) {
                $inis = parse_ini_file("../../.env");
                $pdo = new PDO("mysql:host={$inis['DB_HOST']};dbname={$inis['DB_DATABASE']}", $inis['DB_USERNAME'], $inis['DB_PASSWORD']);
                static::$Instance = $pdo;
            }

        } catch (Exception$e) {
            echo($e->getMessage());
            exit("Exit");
        }
        return static::$Instance;
    }
}

$pdo = Database::getInstance();

function initiate_date(PDO $pdo)
{
    $result = [];
    for ($i = 0; $i < 1000; $i++) {
        array_push($result, ["name:$i", $i % 75, rand(0, 1)]);
    }
    $chunks = array_chunk($result, 800);


    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO `names` (name,age,gender)VALUES(?,?,?)");
    try {
        for ($i = 0; $i < count($chunks); $i++) {
            for ($j = 0; $j < count($chunks[$i]); $j++) {
                $stmt->execute($chunks[$i][$j]);
                if ($stmt->errorCode() != '0000') {
                    throw new Exception($stmt->errorCode() . ":" . $stmt->errorInfo());
                }
            }

        }
        $pdo->commit();
    } catch (Exception$e) {
        echo $e->getMessage();
        $pdo->rollBack();
    }


}


function test_lobs(PDO $pdo, $id)
{
    $stmt = $pdo->prepare("select contenttype, imagedata from images where id=?");
    $stmt->execute([$id]);
    $stmt->bindColumn(1, $type, PDO::PARAM_STR, 256);
    $stmt->bindColumn(2, $lob, PDO::PARAM_LOB);
    /*
     [With bindParam] Unlike PDOStatement::bindValue(), the variable is bound as
     a reference and will only be evaluated at the time that PDOStatement::execute() is called.
     $sex = 'male';
    
    $s = $dbh->prepare('SELECT name FROM students WHERE sex = :sex');
    $s->bindParam(':sex', $sex); // use bindParam to bind the variable
    $sex = 'female';
    $s->execute(); // executed with WHERE sex = 'female'
     *
     */
    $fetch = $stmt->fetch(PDO::FETCH_BOTH);

    header("Content-Type: $type");
    echo $lob;
}

function insert_lob(PDO $pdo)
{
    $stmt = $pdo->prepare("insert into images (id, contenttype, imagedata,date) VALUES (0, ?, ?,NOW(0))");

// 假设处理一个文件上传
// 可以在 PHP 文档中找到更多的信息

    $fp = fopen("test.jpg", 'rb');
    $type = "jpg";

    $stmt->bindParam(1, $type);
    $stmt->bindParam(2, $fp, PDO::PARAM_LOB);


    $pdo->beginTransaction();
    $stmt->execute();
    var_dump($stmt->errorInfo());
    $pdo->commit();
}

//test_lobs($pdo, 1);
initiate_date($pdo);