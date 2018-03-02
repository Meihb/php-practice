<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-13
 * Time: 15:03
 */
include_once "./Template.php";

$tpl =  Template::getInstance();
var_dump($tpl->getConfig());
 $tpl->show('member');