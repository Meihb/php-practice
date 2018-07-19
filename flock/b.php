<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/2/28
 * Time: 16:24
 */

$file = 'test.txt';

/*
$fp = fopen($file, 'r');
if(flock($fp, LOCK_SH)){ // 取得贡献锁
    while(!feof($fp)){
        echo fread($fp, 100);
    }
    flock($fp, LOCK_UN);
}
*/

$fp = fopen($file, 'a');
echo 'start at ' . date('Y-m-d H:i:s')."\r\n";
if (flock($fp, LOCK_EX )) {                    // 取得独占锁
    fwrite($fp, "How Are You\r\n");         // 写入数据
    fwrite($fp, "Show Me The Money\r\n");   // 写入数据
    flock($fp, LOCK_UN);                    // 解锁
} else {
    echo 'ends at'.date("Y-m-d H:i:s")."\r\n";
}


fclose($fp);