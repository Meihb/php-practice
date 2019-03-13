<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/3/13
 * Time: 10:53
 */
include_once "./config.inc.php";

$res = mysqli_query($conn,"SELECT id ,href FROM `weixin_article_read_num` WHERE status = 0 order by id ASC LIMIT 1");

function getWXArticleMid($href){
    $mid_start = strpos($href,"&mid=")+5;
    $left_href = substr($href,$mid_start);
    $mid_end = strpos($left_href,"&");
    $mid = substr($href,$mid_start,$mid_end);
    return $mid;
}

if(mysqli_num_rows($res)>0){
    $data = mysqli_fetch_array($res,MYSQLI_ASSOC);
    $mid = getWXArticleMid($data["href"]);
    mysqli_query($conn,"UPDATE `weixin_article_read_num` SET status = 1,mid = '{$mid}' WHERE id = ".$data["id"]);
    echo  json_encode(["isSuccess"=>true,"href"=>$data["href"],"taskid"=>$data["id"]]);
}else{
    echo json_encode(["isSuccess"=>false,"href"=>""]);
}