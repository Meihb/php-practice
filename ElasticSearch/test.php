<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/9/6
 * Time: 15:35
 */

use Elasticsearch\ClientBuilder;

require '../vendor/autoload.php';


$client = ClientBuilder::create()->setHosts(['118.25.41.135'])->build();


//创建index(mysql中的database)
$params = [
    'index' => 'myindex', #index的名字不能是大写和下划线开头
    'body' => [
        'settings' => [
            'number_of_shards' => 2,
            'number_of_replicas' => 0
        ]
    ]
];
//$params = [
//    'index' => 'my_index',
//    'type' => 'my_type',
//    'id' => 'my_id',
//    'body' => ['testField' => 'abc']
//];
echo 'index:' . "<br>";
$response = $client->index($params);
echo print_r($response,true)."<br>";


$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id'
];

$response = $client->get($params);
echo "get:<br>".print_r($response,true)."<br>";


$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'body' => [
        'query' => [
            'match' => [
                'testField' => 'abc'
            ]
        ]
    ]
];


$response = $client->search($params);
echo "search <br>".print_r($response)."<br>";

/*
$params = [
    'index' => 'test',
    'type' => 'test',
    'id' => 1,
    'client' => [
        'future' => 'lazy',
        'ignore' => [404,]
    ]
];

$future = $client->get($params);

var_dump($doc = $future['_source']);

for ($i = 0; $i < 100; $i++) {
    $params = [
        'index' => 'test',
        'type' => 'test',
        'id' => $i,
        'client' => [
            'future' => 'lazy',
            'ignore' => [404,]
        ]
    ];

    $futures[] = $client->get($params);     //queue up the request
}


foreach ($futures as $future) {
    // access future's values, causing resolution if necessary
    var_dump( $future['_source']);
}