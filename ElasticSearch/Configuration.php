<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/9/10
 * Time: 15:02
 */

use Elasticsearch\ClientBuilder;
require '../vendor/autoload.php';

require '../vendor/autoload.php';

//inline Host配置,每一个值代表集群的一个节点
$hosts = [
    '192.168.1.1:9200',         // IP + Port
    '192.168.1.2',              // Just IP
    'mydomain.server.com:9201', // Domain + Port
    'mydomain2.server.com',     // Just Domain
    'https://localhost',        // SSL to localhost
    'https://192.168.1.3:9200'  // SSL to IP + Port
];


/*extended Host配置方法
 Inline Host 配置法依赖 PHP 的 filter_var() 函数和 parse_url() 函数来验证和提取一个 URL 的各个部分。
然而，这些 php 函数在一些特定的场景下会出错。例如， filter_var() 函数不接收有下划线的 URL。
同样，如果 Basic Auth 的密码含有特定字符（如#、?），那么 parse_url() 函数会报错。
*/
$hosts = [
    // This is effectively equal to: "https://username:password!#$?*abc@foo.com:9200/"
    [
        'host' => 'foo.com',
        'port' => '9200',
        'scheme' => 'https',
        'user' => 'username',
        'pass' => 'password!#$?*abc'
    ],

    // This is equal to "http://localhost:9200/"
    [
        'host' => 'localhost',    // Only host is required
    ]
];

$client = ClientBuilder::create()->setHosts(['118.25.41.135'])->build();

$params = [
    'index' => 'test_missing',
    'type' => 'test',
    'id' => 1,
    'client' => ['ignore' => 404]
];
echo $client->get($params);