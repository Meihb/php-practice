<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/7/19
 * Time: 10:35
 */
$dbname = 'DQX_Act';
$host = '10.2.0.12';
$user = 'root';
$port = '';
$pwd = 'pQU0H3evY92aMbdZ';


$conn = new mysqli($host, $user, $pwd, $dbname);
$conn->set_charset('utf8');


function tst1()
{
    global $conn;
    $stmt = $conn->stmt_init();
    $stmt->prepare("SELECT pet_id,vote_count,date,pet_name FROM `petappraise_vote_count` where  pet_id <= ? ");
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
}


function tst_flexible_params(){
    global $conn;
    $stmt = $conn->stmt_init();
    $stmt->prepare("SELECT id,pt_id FROM `ff14_recruit_personal_profile` WHERE id>=? AND group_id>=?");

    $args = [1,5];
    $args = refValues($args);
    var_dump($args);
    $callback = [$stmt,"bind_param"];
    array_unshift($args,"ii");



    call_user_func_array($callback,$args);
    $execute = $stmt->execute();
    $stmt->bind_result($id, $info);   //绑定结果格式

    if ($execute) {
        $stmt->store_result();//从预处理语句中获取结果集,预处理语句会将结果集保存在sql开辟的内存中，调用次函数后会保存到php内存中,直接影响affected_rows和num_rows(mysql_affected_rows 取得前一次 MySQL 操作所影响的记录行数，操作是指INSERT、UPDATE、DELETE等，影响是指修改、变化的。如果函数失败，返回值是-1。此函数参数为连接ID，也可以不要参数（当前默认的连接）。
//mysql_num_rows()返回结果集中行的数目，仅对 SELECT 语句有效)

        echo 'affected rows is ' . $count = $stmt->affected_rows . '<br>' . 'num_rows is ' . $nums = $stmt->num_rows;
        while ($row = $stmt->fetch()) {//无需先执行store_result,请记住:在mysqli预处理中取出数据,只能使用fetch()这是因为mysqli_stmt类并没有其它取值方法
            var_dump($id, $info);
        }
    } else {
        echo 'Oops,something broken' . "<br>";
        echo $stmt->error, $stmt->errno;
    }





    $stmt->close();
//    $conn->close();
}

function execute_stmt(){
    global $conn;
    $sql_str = "SELECT id,pt_id FROM `ff14_recruit_personal_profile` WHERE id>=? AND group_id>=?";
    $params = ["ii",1,1];
    $stmt = $conn->stmt_init();
    $stmt->prepare( $sql_str);
    if ( $stmt ){
        foreach($params as $k=>$v){
            $array[] = &$params[$k]; //注意此处的引用
        }
        call_user_func_array(array($stmt, 'bind_param'), $array); // 魔术方法直接call
        $execute = $stmt->execute();

        if ($execute) {
            $stmt->bind_result($id, $info);
            $stmt->store_result();

            echo 'affected rows is ' . $count = $stmt->affected_rows . '<br>' . 'num_rows is ' . $nums = $stmt->num_rows;
            while ($row = $stmt->fetch()) {//无需先执行store_result,请记住:在mysqli预处理中取出数据,只能使用fetch()这是因为mysqli_stmt类并没有其它取值方法
                var_dump($id, $info);
            }
        } else {
            echo 'Oops,something broken' . "<br>";
            echo $stmt->error, $stmt->errno;
        }
        // 若干方法
    }
}

/**
 * 预处理变长参数
 * @param $sql
 * @param $typeStr
 * @param $params
 * @return bool|mysqli_stmt
 */
function stmt_execute($sql,$typeStr,$params){
    global $conn;
    $stmt = $conn->stmt_init();
    $stmt->prepare($sql);
    if($stmt){
        foreach ($params as $key=>$param){
            $array[] = &$params[$key];
        }
        array_unshift($array,$typeStr);
        call_user_func_array([$stmt,'bind_param'],$array);
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return false;
        }
    }
    return false;
}

stmt_execute(  "SELECT id,pt_id FROM `ff14_recruit_personal_profile` WHERE id>=? AND group_id>=?",'ii',$params = [1,1]);

function refValues($arr)
{
    echo phpversion();
    if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
    {
        $refs = array();
        foreach ($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}

/**
 * @param $a
 * @param $b
 * @return mixed
 */
function tst($a, $b)
{
    return $a + $b;
}

