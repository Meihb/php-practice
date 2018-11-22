<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/11/22
 * Time: 17:09
 */
class ShareCodeUtils
{
    /**
     * 100w次无重复,且解析成功
     * 自定义进制(0,1没有加入,容易与o,l混淆)，数组顺序可进行调整增加反推难度，A用来补位因此此数组不包含A，共31个字符。
     */
    private static $BASE = "HVE8S2DZX9C7P5IK3MJUFR4WYLTN6BGQ";

    /**
     * A补位字符，不能与自定义重复
     */
    private static $SUFFIX_CHAR = 'A';

    /**
     * 进制长度
     */
    private static $BIN_LEN;

    /**
     * 生成邀请码最小长度
     */
    private static $CODE_LEN = 8;


    /**
     * ID转换为邀请码
     *
     * @param int id
     * @return string
     */
    public static function idToCode($id)
    {
        ShareCodeUtils::$BIN_LEN = strlen(ShareCodeUtils::$BASE);
        $buf = "                                ";
        $charPos = ShareCodeUtils::$BIN_LEN;
        $bin_len = ShareCodeUtils::$BIN_LEN;

        // 当id除以数组长度结果大于0，则进行取模操作，并以取模的值作为数组的坐标获得对应的字符
        while (floor($id / $bin_len) > 0) {
            $index = (int)($id % $bin_len);
            $buf[--$charPos] = ShareCodeUtils::$BASE[$index];
            $id /= $bin_len;
        }
        $buf[--$charPos] = ShareCodeUtils::$BASE[(int)($id % $bin_len)]; ;
        // 将字符数组转化为字符串
//        $result = new String(buf, charPos, BIN_LEN - charPos);
        $result = substr($buf, $charPos, $bin_len - $charPos);
        $len = strlen($result);
        if ($len < ShareCodeUtils::$CODE_LEN) {
            $temp_str = ShareCodeUtils::$SUFFIX_CHAR;
            // 去除SUFFIX_CHAR本身占位之后需要补齐的位数
            for ($i = 0; $i < ShareCodeUtils::$CODE_LEN - $len - 1; $i++) {
                $temp_str .= (ShareCodeUtils::$BASE[rand(0, ShareCodeUtils::$BIN_LEN)]);
            }
            $result .= $temp_str;
        }
        return $result;
    }


    /**
     * 邀请码解析出ID<br/>
     * 基本操作思路恰好与idToCode反向操作。
     *
     * @param string code
     * @return
     */
    public static function codeToId($code)
    {
        ShareCodeUtils::$BIN_LEN = strlen(ShareCodeUtils::$BASE);
        $charArray = $code;
        $result = 0;
        for ($i = 0; $i < strlen($charArray); $i++) {
            $index = 0;
            for ($j = 0; $j < ShareCodeUtils::$BIN_LEN; $j++) {
                if ($charArray[$i] == ShareCodeUtils::$BASE[$j]) {
                    $index = $j;
                    break;
                }
            }
            if ($charArray[$i] == ShareCodeUtils::$SUFFIX_CHAR) {
                break;
            }

            if ($i > 0) {
                $result = $result * ShareCodeUtils::$BIN_LEN + $index;
            } else {
                $result = $index;
            }
        }

        return $result;

    }

}