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
        'http://a.practice.snda.com',
        'http://practice.snda.com',
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


function handleCors2()
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
        'http://122.152.218.18',
        'http://122.152.219.157',
        'http://act1.ff.sdo.com',
        'http://act1.dq.sdo.com',
        'https://act1.ff.sdo.com',
        "https://actff1.web.sdo.com",
    ];
    if (empty($origin)) {
        header("Access-Control-Allow-Origin: *");
//        header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, OPTIONS');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN,X-REQUESTED-WITH');
        header('Access-Control-Expose-Headers:Authorization, authenticated');
        header('Access-Control-Allow-Credentials:true');
    } else if (in_array($origin, $allow_origins)) {
        header("Access-Control-Allow-Origin: $origin");
//        header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, OPTIONS');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN,X-REQUESTED-WITH');
        header('Access-Control-Expose-Headers:Authorization, authenticated');
        header('Access-Control-Allow-Credentials:true');

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            /*浏览器的同源策略，就是出于安全考虑，浏览器会限制从脚本发起的跨域HTTP请求（比如异步请求GET, POST, PUT, DELETE, OPTIONS等等），所以浏览器会向所请求的服务器发起两次请求，第一次是浏览器使用OPTIONS方法发起一个预检请求，第二次才是真正的异步请求，第一次的预检请求获知服务器是否允许该跨域请求：如果允许，才发起第二次真实的请求；如果不允许，则拦截第二次请求。
    Access-Control-Max-Age用来指定本次预检请求的有效期，单位为秒，，在此期间不用发出另一条预检请求。 包含Url和传参
            */
            //disable cache 也会导致无法使用max-age
            header('Access-Control-Max-Age:300');
            exit("options exit");
        }

    } else {
        exit("Host Not Allowed");
    }
}

ini_set("session.save_path", "D:/\/\sessions");
ini_set("session.cookie_domain", '.snda.com');//注：此句必须放在session_start()之前



session_start();