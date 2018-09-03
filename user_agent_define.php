<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/9/3
 * Time: 12:00
 */
function my_get_browser()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return '命令行，机器人来了！';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0')) {
        return 'Internet Explorer 9.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) {
        return 'Internet Explorer 8.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) {
        return 'Internet Explorer 7.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) {
        return 'Internet Explorer 6.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
        return 'Firefox';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
        return 'Chrome';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
        return 'Safari';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
        return 'Opera';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], '360SE')) {
        return '360SE';
    } else {
        return '';
    }
}


function define_ie()
{
    $agent = my_get_browser();
    if ($agent == 'Internet Explorer 9.0' || $agent == 'Internet Explorer 8.0' || $agent == 'Internet Explorer 7.0' || $agent == 'Internet Explorer 6.0') {
        return true;
    } else {
        return false;
    }
}

/**
 * gbk或gb2312转为utf8，主要处理ie传参问题
 * @param $str
 * @return string
 */
function gbk2utf8($str)
{
    $charset = mb_detect_encoding($str, array('UTF-8', 'GBK', 'GB2312'));
    $charset = strtolower($charset);
    if ('cp936' == $charset) {
        $charset = 'GBK';
    }
    if ("utf-8" != $charset) {
        $str = iconv($charset, "UTF-8//IGNORE", $str);
    }
    return $str;
}
