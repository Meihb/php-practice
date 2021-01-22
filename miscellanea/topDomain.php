<?php
header('content-type:text/html;charset=utf-8');
//获取顶级域名
function getTopHost($url){
    $url = strtolower($url);  //首先转成小写
    $hosts = parse_url($url);
    $host = $hosts['host'];
    //查看是几级域名
    $data = explode('.', $host);
    $n = count($data);
    //判断是否是双后缀
    $preg = '/[\w].+\.(com|net|org|gov|edu)\.cn$/';
    if(($n > 2) && preg_match($preg,$host)){
        //双后缀取后3位
        $host = $data[$n-3].'.'.$data[$n-2].'.'.$data[$n-1];
    }else{
        //非双后缀取后两位
        $host = $data[$n-2].'.'.$data[$n-1];
    }
    return $host;
}
// 测试
echo getTopHost("http://ABC.com/s/j?wd=djl"),'<br>';
echo getTopHost("http://www.abc.com/s/j?wd=djl"),'<br>';
echo getTopHost("http://2.www.abc.com/s/j?wd=djl"),'<br>';
echo getTopHost("https://mp.weixin.qq.com/s?__biz=MzA3ODI3ODUzMw=="),'<br>';
echo getTopHost("http://cfi.net.cn/"),'<br>';
echo getTopHost("http://www.cfi.NEt.cn/"),'<br>';
echo getTopHost("https://www.sina.com.cn/?from=kandian"),'<br>';
echo getTopHost("https://llas.web.sdo.com/web1/index.html"),'<br>';
echo getTopHost("https://login.sdo.com/sdo/iframe/?appId=791000478&areaId=1&returnURL=https%3A%2F%2Fact1.ff.sdo.com%2FLLAS%2FGhome%2Flogin%3FredirectUrl%3Dhttps%3A%2F%2Fllas.web.sdo.com%2Fweb1%2Findex.html"),'<br>';

