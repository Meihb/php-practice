<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-23
 * Time: 14:32
 */
include_once "../redis/SessionManager.php";
new SessionManager();

//var_dump($_SESSION);
echo $_SESSION['user12'];