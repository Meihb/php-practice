<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/9/11
 * Time: 12:07
 */
require_once "./build.php";

//$params = [
//    'index' => 'reuters',
//    'body' => [
//        'settings' => [
//            'number_of_shards' => 1,
//            'number_of_replicas' => 0,
//            'analysis' => [
//                'filter' => [
//                    'shingle' => [
//                        'type' => 'shingle'
//                    ]
//                ],
//                'char_filter' => [
//                    'pre_negs' => [
//                        'type' => 'pattern_replace',
//                        'pattern' => '(\\w+)\\s+((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))\\b',
//                        'replacement' => '~$1 $2'
//                    ],
//                    'post_negs' => [
//                        'type' => 'pattern_replace',
//                        'pattern' => '\\b((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))\\s+(\\w+)',
//                        'replacement' => '$1 ~$2'
//                    ]
//                ],
//                'analyzer' => [
//                    'reuters' => [
//                        'type' => 'custom',
//                        'tokenizer' => 'standard',
//                        'filter' => ['lowercase', 'stop', 'kstem']
//                    ]
//                ]
//            ]
//        ],
//        'mappings' => [
//            '_default_' => [
//                'properties' => [
//                    'title' => [
//                        'type' => 'string',
//                        'analyzer' => 'reuters',
//                        'term_vector' => 'yes',
//                        'copy_to' => 'combined'
//                    ],
//                    'body' => [
//                        'type' => 'string',
//                        'analyzer' => 'reuters',
//                        'term_vector' => 'yes',
//                        'copy_to' => 'combined'
//                    ],
//                    'combined' => [
//                        'type' => 'string',
//                        'analyzer' => 'reuters',
//                        'term_vector' => 'yes'
//                    ],
//                    'topics' => [
//                        'type' => 'string',
//                        'index' => 'not_analyzed'
//                    ],
//                    'places' => [
//                        'type' => 'string',
//                        'index' => 'not_analyzed'
//                    ]
//                ]
//            ],
//            'my_type' => [
//                'properties' => [
//                    'my_field' => [
//                        'type' => 'string'
//                    ]
//                ]
//            ]
//        ]
//    ]
//];
//$client->indices()->create($params);