<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-19
 * Time: 15:10
 */

function mHash_analyze($key)
{
    var_dump('this is md5 '. md5($key));
    $md5 = substr(md5($key), 0, 8);
    var_dump('this is md5 substr '.$md5);
    var_dump('this is md5 substr '.bin2hex($md5));
    $seed = 31;
    $hash = 0;

    for ($i = 0; $i < 8; $i++) {/*
　ASCII码：
　　一个英文字母（不分大小写）占一个字节的空间，一个中文汉字占两个字节的空间。一个二进制数字序列，在计算机中作为一个数字单元，一般为8位二进制数，换算为十进制。最小值0，最大值255。如一个ASCII码就是一个字节。
　　UTF-8编码：
　　一个英文字符等于一个字节，一个中文（含繁体）等于三个字节。
　　Unicode编码：
　　一个英文等于两个字节，一个中文（含繁体）等于两个字节。
　　符号：
　　英文标点占一个字节，中文标点占两个字节。举例：英文句号“.”占1个字节的大小，中文句号“。”占2个字节的大小。
*/
        var_dump($hash*$seed,ord($md5[$i]));
        $hash = $hash * $seed + ord($md5[$i]);
        var_dump($hash);
        var_dump(bin2hex($hash));
        $i++;
    }

    return $hash& 0x7FFFFFFF;
}
var_dump('this is result 1', decbin(mHash_analyze('meihb')));