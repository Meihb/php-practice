<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/9/11
 * Time: 12:07
 */

use Elasticsearch\ClientBuilder;

require '../vendor/autoload.php';


$client = ClientBuilder::create()->setHosts(['118.25.41.135'])->build();