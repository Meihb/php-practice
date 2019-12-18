<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/12/17
 * Time: 11:09
 */

ini_set("session.use_trans_sid", "1");//使用重写url方式
ini_set("session.use_only_cookies", 0);//不 仅仅使用cookie
ini_set("session.use_cookies", 1);//开启cookie


session_start();
