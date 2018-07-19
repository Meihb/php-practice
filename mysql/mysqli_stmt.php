<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/7/19
 * Time: 10:35
 */
$dbname = 'dwts';
$host = '';
$user = 'root';
$port = '';
$pwd = '12121992';


$conn = new mysqli($host, $user, $pwd, $dbname);
$conn->set_charset('utf8');

$stmt = $conn->stmt_init();

$stmt->prepare("SELECT id,recognitions,process_status,word FROM `baidu_index` where  pet_id <= ? ");
$stmt->bind_param('i', $id);//,i表示整型,d表示浮点型,b代表二进制,s代表其它的所有
$stmt->bind_result($pet_id, $vote_count, $date, $name);   //绑定结果格式
$id = 10;

$execute = $stmt->execute();
if ($execute) {
    var_dump($execute);
    $sr = $stmt->store_result();//从预处理语句中获取结果集,预处理语句会将结果集保存在sql开辟的内存中，调用次函数后会保存到php内存中,直接影响affected_rows和num_rows(mysql_affected_rows 取得前一次 MySQL 操作所影响的记录行数，操作是指INSERT、UPDATE、DELETE等，影响是指修改、变化的。如果函数失败，返回值是-1。此函数参数为连接ID，也可以不要参数（当前默认的连接）。
//mysql_num_rows()返回结果集中行的数目，仅对 SELECT 语句有效)

    echo 'affected rows is ' . $count = $stmt->affected_rows . '<br>' . 'num_rows is ' . $nums = $stmt->num_rows;
    while ($row = $stmt->fetch()) {//无需先执行store_result,请记住:在mysqli预处理中取出数据,只能使用fetch()这是因为mysqli_stmt类并没有其它取值方法
        var_dump($pet_id, $vote_count, $date, $name);
    }
} else {
    echo 'Oops,something broken' . "<br>";
    echo $stmt->error, $stmt->errno;
}




$stmt->close();
$conn->close();


