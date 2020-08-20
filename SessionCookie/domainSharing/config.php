<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/8/14
 * Time: 14:17
 */


function handleCors()
{

//    var_dump($_SERVER);
    /*
     *web访问
     *  Array\n(\n
     * [UNIQUE_ID] => XwV5eqHlK9@N4ZcP4LTZ7wAAAAg\n
     * [HTTP_HOST] => act1.ff.sdo.com\n
     * [HTTP_CONNECTION] => keep-alive\n
     * [HTTP_ACCEPT] => application/json, text/javascript, *\/*; q=0.01\n
     * [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36\n
     * [HTTP_ORIGIN] => http://122.152.219.157\n
     * [HTTP_REFERER] => http://122.152.219.157/20200702Livelottery/index.html\n
     * [HTTP_ACCEPT_ENCODING] => gzip, deflate\n
     * [HTTP_ACCEPT_LANGUAGE] => zh,zh-CN;q=0.9,en;q=0.8,ja;q=0.7,zh-TW;q=0.6\n
     * [PATH] => /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin\n
     * [SERVER_SIGNATURE] => \n
     * [SERVER_SOFTWARE] => Apache/2.4.6 (CentOS) OpenSSL/1.0.2k-fips PHP/5.4.16\n
     * [SERVER_NAME] => act1.ff.sdo.com\n    [SERVER_ADDR] => 10.2.0.3\n
     * [SERVER_PORT] => 80\n    [REMOTE_ADDR] => 180.166.81.82\n
     * [DOCUMENT_ROOT] => /data/www/html\n    [REQUEST_SCHEME] => http\n    [CONTEXT_PREFIX] => \n    [CONTEXT_DOCUMENT_ROOT] => /data/www/html\n    [SERVER_ADMIN] => root@localhost\n    [SCRIPT_FILENAME] => /data/www/html/FF14DataApi/LiveLottery20200628/index.php\n    [REMOTE_PORT] => 59606\n    [GATEWAY_INTERFACE] => CGI/1.1\n    [SERVER_PROTOCOL] => HTTP/1.1\n    [REQUEST_METHOD] => GET\n    [QUERY_STRING] => act=hasLogin\n    [REQUEST_URI] => /FF14DataApi/LiveLottery20200628/index.php?act=hasLogin\n    [SCRIPT_NAME] => /FF14DataApi/LiveLottery20200628/index.php\n    [PHP_SELF] => /FF14DataApi/LiveLottery20200628/index.php\n    [REQUEST_TIME_FLOAT] => 1594194298.886\n    [REQUEST_TIME] => 1594194298\n)\n
     *
     *
     *
     * curl访问
     * Array\n(\n
     * [UNIQUE_ID] => XwWEhwY8u0yY70ZHvc3TrAAAAAU\n
     * [HTTP_USER_AGENT] => curl/7.29.0\n
     * [HTTP_HOST] => 10.2.0.3\n
     * [HTTP_ACCEPT] => *\/*\n
     * [PATH] => /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin\n
     * [SERVER_SIGNATURE] => \n
     * [SERVER_SOFTWARE] => Apache/2.4.6 (CentOS) OpenSSL/1.0.2k-fips PHP/5.4.16\n
     * [SERVER_NAME] => 10.2.0.3\n
     * [SERVER_ADDR] => 10.2.0.3\n
     * [SERVER_PORT] => 80\n
     * [REMOTE_ADDR] => 10.2.0.17\n
     * [DOCUMENT_ROOT] => /data/www/html\n
     * [REQUEST_SCHEME] => http\n
     * [CONTEXT_PREFIX] => \n
     * [CONTEXT_DOCUMENT_ROOT] => /data/www/html\n
     * [SERVER_ADMIN] => root@localhost\n
     * [SCRIPT_FILENAME] => /data/www/html/FF14DataApi/LiveLottery20200628/index.php\n
     * [REMOTE_PORT] => 51688\n
     * [GATEWAY_INTERFACE] => CGI/1.1\n
     * [SERVER_PROTOCOL] => HTTP/1.1\n
     * [REQUEST_METHOD] => GET\n
     * [QUERY_STRING] => act=hasLogin&sndaid=3\n
     * [REQUEST_URI] => /FF14DataApi/LiveLottery20200628/index.php?act=hasLogin&sndaid=3\n
     * [SCRIPT_NAME] => /FF14DataApi/LiveLottery20200628/index.php\n
     * [PHP_SELF] => /FF14DataApi/LiveLottery20200628/index.php\n
     * [REQUEST_TIME_FLOAT] => 1594197127.247\n
     * [REQUEST_TIME] => 1594197127\n)
     */

    $origin = isset($_SERVER['HTTP_ORIGIN']) && !empty($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : "";//origin代表跨域请求,非跨域请求无此header
    $allow_origins = [
        'http://a.practice.com:8080',
    ];
    if (empty($origin)) {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, OPTIONS');
        header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN,X-REQUESTED-WITH');
        header('Access-Control-Expose-Headers:Authorization, authenticated');
        header('Access-Control-Allow-Credentials:true');
    } else if (in_array($origin, $allow_origins)) {
        header("Access-Control-Allow-Origin: $origin");
        header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, OPTIONS');
        header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN,X-REQUESTED-WITH');
        header('Access-Control-Expose-Headers:Authorization, authenticated');
        header('Access-Control-Allow-Credentials:true');
    } else {
        exit("Host Not Allowed");
    }
}

ini_set("session.save_path", "D:/\/\sessions");
ini_set("session.cookie_domain", '.practice.com');//注：此句必须放在session_start()之前


if (!empty($_GET['phpsessid'])) {
    session_id($_GET['phpsessid']);
}

session_start();