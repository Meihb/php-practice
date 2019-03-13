<?php
//@header('Content-type:text/json;charset=UTF-8');
date_default_timezone_set("PRC");
session_start();



/*$dbname = 'Mir_Act';
$host = 'localhost';
$port = 3306;
$user = 'huangyong';
$pwd = 'admin030248';
$tablepre = 'ACTMir_friends_';

$link = mysqli_connect("{$host}:{$port}",$user,$pwd,$dbname);*/




$CREATE_SQL = "CREATE TABLE IF NOT EXISTS `weixin_article_read_num` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `href` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `extra` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";

$IP = CDNgetIp();
$dbname = 'testDB';
$host = '10.2.0.12';
$user = 'test';
$port = '';
$pwd = 'test123456';


$link = mysqli_connect("{$host}{$port}", $user, $pwd, $dbname);
$conn = $link;
if (mysqli_connect_errno($link))
    die('Could not connect: ' . mysqli_connect_error());


/*$link = @mysql_connect("{$host}:{$port}",$user,$pwd,$dbname);
if(!$link) {die("连接服务器失败: " . mysql_error());}
if(!mysql_select_db($dbname,$link)) {die("选择数据库失败: " . mysql_error($link));}*/

mysqli_query($link, "set names 'utf8'");
mysqli_query($link, "set character_set_client=utf8");
mysqli_query($link, "set character_set_results=utf8");


//sql注入过滤函数
function phpsql_show($str)
{
    $str = stripslashes($str);
    $str = str_replace("&#92;", "", $str);
    $str = str_replace("&#47;", "/", $str);
    $str = str_replace("&#32;", " ", $str);
    $str = str_replace("&#44;", ",", $str);
    return $str;
}

function phpsql_post($str)
{
    $str = stripslashes($str);
    $str = str_replace("|", "&#124;", $str);
    $str = str_replace("<", "&#60;", $str);
    $str = str_replace(">", "&#62;", $str);
    $str = str_replace("&nbsp;", "&#32;", $str);
    $str = str_replace(" ", "&#32;", $str);
    $str = str_replace("(", "&#40;", $str);
    $str = str_replace(")", "&#41;", $str);
    $str = str_replace("`", "&#96;", $str);
    //$str = str_replace("'", "&#39;", $str);
    $str = str_replace('"', "&#34;", $str);
    $str = str_replace(",", "&#44;", $str);
    $str = str_replace("$", "&#36;", $str);
    $str = str_replace("", "&#92;", $str);
    $str = str_replace("/", "&#47;", $str);
    return $str;
}

//透过CDN获取客户端IP
function CDNgetIp()
{
    $TcpIp = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);

        for ($i = 0; $i < count($ips); $i++) {
            if (stripos($i, $TcpIp) == 0) {
                $Ip = $ips[0];
                break;
            }
        }
        if (strlen($Ip) == 0) $Ip = $TcpIp;
    } else $Ip = $TcpIp;

    return $Ip;

}


