<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/3/13
 * Time: 13:42
 */

/**
 * 借鉴文章 https://blog.csdn.net/qq_19383667/article/details/79380212
 */
include_once "./config.inc.php";

if(empty($_GET['queryUrl'])||!isset($_GET["queryUrl"])){
    echo json_encode(["isSuccess"=>false,"errormsg"=>"请指定具体列表连接待爬取"]);
}

$queryUrl = $_GET["queryUrl"];


