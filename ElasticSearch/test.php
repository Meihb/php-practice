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


$params = [
    'index' => 'myindex', #index的名字不能是大写和下划线开头
    'body' => [
        'settings' => [
            'number_of_shards' => 2,
            'number_of_replicas' => 0
        ]
    ]
];
$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id',
    'body' => ['testField' => 'abc']
];

$response = $client->index($params);
print_r($response);




$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id'
];

$response = $client->get($params);
print_r($response);


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
print_r($response);