<?php
/**
 * Created by PhpStorm.
 * User: 12538
 * Date: 2019-10-4
 * Time: 21:14
 */

return [
    'vendor' => [
        'path' => dirname(dirname(__DIR__)) . '/vendor'
    ],
    'rabbitmq' => [
        'host' => '118.25.41.135',
        'port' => '5672',
        'login' => 'myuser',
        'password' => 'mypass',
        'vhost' => '/'
    ]
];