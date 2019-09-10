<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-15
 * Time: 15:45
 */
/***********简单配置******************/
/*
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"http://www.phpnet.com");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//将curl_exec()获取的信息以文件流的方式返回,而非直接输出
curl_setopt($ch,CURLOPT_HEADER,1);//启用时会将头文件的信息作为数据流输出

//执行并获取HTML文档内容
$output = curl_exec($ch);
if($output===false){
    echo "curl Error:".curl_error($ch);
}
$info = curl_getinfo($ch);//curl请求相关信息
//var_dump($info);
//释放句柄
curl_close($ch);
echo $output;
*/

/*************抓取图片*************/
/*
@header('Content-type:image/png');
//初始化
$ch = curl_init();
//设置选项,包括URL
curl_setopt($ch, CURLOPT_URL, "http://road.ishaking.com/dtsy/images/nav-wy.png");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
//执行并获取内容
$output = curl_exec($ch);
//释放句柄
$info = curl_getinfo($ch);
curl_close($ch);
file_put_contents("../resource/curl.png",$output);
$size = filesize("../resource/curl.png");
if($size!=$info['size_download']){
    echo '下载数据不完整';
    //尝试重新下载
}else{
//    echo '下载完整';
    echo $output;
}
*/
/*******************伪造UA****************/
//@header('Content-type:text/html;charset=utf-8');
////第一次初始化
//$ch = curl_init();
//curl_setopt($ch,CURLOPT_URL,"http://3g.qq.com");
//curl_setopt($ch,CURLOPT_TRANSFER_ENCODING,1);
//$h = array('HTTP_VIA:HTTP/1.1 SNXA-PS-WAP-GW21 (infoX-WISG,Huawei Technologies)',
//'HTTP_ACCEPT:application/vnd.wap.wmlscriptc,text/vnd.wap.wml,application/vnd.wap.xhtml+xml,application/xhtml+xml,text/html,multipart/mixed,*/* ',
//'Http');

/****************模拟post请求**************/
/*
$post_data = ["projCode"=>"004","query"=>"php","action"=>"Submit"];
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"http://www.ishaking.com/route/ddl_ctrl.php?fc_pc&index&getSingleProjConfig");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_HEADER,1);
//设置为POST
curl_setopt($ch,CURLOPT_POST,1);
//添加post变量
curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
$output = curl_exec($ch);
var_dump(curl_getinfo($ch));
curl_close($ch);
echo $output;
*/
/***************模拟文件上传,php5.5以上使用curlfile**************/
/*
// Create a CURLFile object / procedural method
$cfile = curl_file_create("H:\GitList\homeSpace\huaweiCloud-laravel-selflearning/resource/1.jpg",'image/png','testpic'); // try adding

// Create a CURLFile object / oop method
$cfile = new CURLFile('H:\GitList\homeSpace\huaweiCloud-laravel-selflearning/resource/1.jpg','image/png','testpic'); // uncomment and use if the upper procedural method is not working.

// Assign POST data
$imgdata = array('myimage' => $cfile);


$ch = curl_init();
$url = "http://122.112.248.56/practice/request.php";
$post_data = [
    'name'=>'mhb',
    'upload'=>$cfile,
];
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_HEADER,true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);

$output = curl_exec($ch);
curl_close($ch);
echo $output;
*/
/**************批处理curl*************/
$ch1 = curl_init();
$ch2 = curl_init();
//指定适当的参数和URL
curl_setopt($ch1, CURLOPT_URL, "http://122.112.248.56/practice/redis.php");
curl_setopt($ch2, CURLOPT_URL, "http://122.112.248.56/practice/request.php");
curl_setopt($ch1, CURLOPT_HEADER, false);
curl_setopt($ch2, CURLOPT_HEADER, false);
//创建批处理句柄
$mh = curl_multi_init();
//绑定前两个资源句柄
curl_multi_add_handle($mh, $ch1);
curl_multi_add_handle($mh, $ch2);
//预定义状态变量
$active = null;
do {
    $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);
while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
}
//关闭句柄
curl_multi_remove_handle($mh, $ch1);
curl_multi_remove_handle($mh, $ch1);
curl_multi_close($mh);