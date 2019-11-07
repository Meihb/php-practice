<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/10/30
 * Time: 11:09
 */


$conn = require_once "./config.inc.php";

//开启慢查询、设定慢查询时间阈值、记录未使用索引查询
$slow_query = "
    SET GLOBAL slow_query_log=ON;
    SET GLOBAL long_query_time = 3600;
    SET GLOBAL log_querise_not_using_indexes = ON; 
";
