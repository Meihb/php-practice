<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/2/28
 * Time: 16:24
 */

$file = 'test.txt';


/*****独占锁*************/
/*
$fp = fopen($file, 'w');
if (flock($fp, LOCK_EX)) {            // 取得独占锁
    fwrite($fp, "Hello World\r\n"); // 写入数据
    sleep(4);                      // sleep 10秒，文件被锁定
    fwrite($fp, "Hello PHP\r\n");   // 写入数据
    flock($fp, LOCK_UN);            // 解锁
}
*/

/*****共享锁*************/
/*
$fp = fopen($file, 'r');
if (flock($fp, LOCK_SH)) { // 取得共享锁
    sleep(4);           // sleep 10秒
    while (!feof($fp)) {
        echo fread($fp, 100);
    }
    flock($fp, LOCK_UN);
}
*/
/*********两者都是共享锁,写入文件a+*****/

$fp = fopen($file, 'a');
if(flock($fp, LOCK_EX)){            // 取得独占锁
    //一定要弄清楚这里边用的是if而非while,while针对的是锁状态,而if则针对的是阻塞
    fwrite($fp, "Hello World\r\n"); // 写入数据
    sleep(4);                      // sleep 10秒，文件被锁定
    fwrite($fp, "Hello PHP\r\n");   // 写入数据
    flock($fp, LOCK_UN);            // 解锁
}

fclose($fp);