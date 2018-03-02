<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-19
 * Time: 14:23
 */
header("P3P: CP=CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR");

setcookie("cookieTest", "xxx".Rand(0, 1000), time() + 3600, "/", "www.atest.com");
//
//session_start();
//$a = session_name();
//$b = session_id();
//var_dump($b);
//echo "<a href = new.php?$a=$b>new2</a>";