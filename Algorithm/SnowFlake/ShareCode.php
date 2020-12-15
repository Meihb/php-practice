<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/12/4
 * Time: 15:37
 */




class ShareCode
{
    /**
     * 100w次无重复,且解析成功
     * 自定义进制(0,1没有加入,容易与o,l混淆)，数组顺序可进行调整增加反推难度，A用来补位因此此数组不包含A，共31个字符。
     */
    private static $BASE = "5IKSZF2XW9C7HVP34Y6J8TBQMDRLNGUE";

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
    private static $CODE_LEN = 13;

    //rc4对称加密算法
    static public function rc4($pwd, $data)
    {
        $cipher = '';
        $key[] = "";
        $box[] = "";
        $pwd_length = strlen($pwd);
        $data_length = strlen($data);
        for ($i = 0; $i < 256; $i++) {
            $key[$i] = ord($pwd[$i % $pwd_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $key[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $data_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $k = $box[(($box[$a] + $box[$j]) % 256)];
            $cipher .= chr(ord($data[$i]) ^ $k);
        }
        return $cipher;
    }

    /**
     * ID转换为邀请码
     *
     * @param int id
     * @return string
     */
    public static function idToCode($id)
    {
        self::$BIN_LEN = strlen(self::$BASE);
        $buf = "";//32位空白字符串
        for ($i = 0; $i < self::$BIN_LEN; $i++) {
            $buf .= " ";
        }
        $charPos = self::$BIN_LEN;
        $bin_len = self::$BIN_LEN;

        // 当id除以数组长度结果大于0，则进行取模操作，并以取模的值作为数组的坐标获得对应的字符
        while (floor($id / $bin_len) > 0) {
            $index = (int)($id % $bin_len);
            $buf[--$charPos] = self::$BASE[$index];
            $id /= $bin_len;
        }
        $buf[--$charPos] = self::$BASE[(int)($id % $bin_len)];;
        // 将字符数组转化为字符串
        $result = substr($buf, $charPos, $bin_len - $charPos);
        $len = strlen($result);
        if ($len < self::$CODE_LEN) {
            $temp_str = self::$SUFFIX_CHAR;
            // 去除SUFFIX_CHAR本身占位之后需要补齐的位数
            for ($i = 0; $i < self::$CODE_LEN - $len - 1; $i++) {
                $temp_str .= self::$BASE[rand(0, self::$BIN_LEN - 1)];
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
        self::$BIN_LEN = strlen(self::$BASE);
        $charArray = $code;
        $result = 0;
        for ($i = 0; $i < strlen($charArray); $i++) {
            $index = 0;
            for ($j = 0; $j < self::$BIN_LEN; $j++) {
                if ($charArray[$i] == self::$BASE[$j]) {
                    $index = $j;
                    break;
                }
            }
            if ($charArray[$i] == self::$SUFFIX_CHAR) {
                break;
            }

            if ($i > 0) {
                $result = $result * self::$BIN_LEN + $index;
            } else {
                $result = $index;
            }
        }

        return $result;

    }

    /**
     * @param string $string 要加密/解密的字符串
     * @param string $operation 类型，ENCODE 加密；DECODE 解密
     * @param string $key 密匙
     * @param int $expiry 有效期
     * @return string
     */
    static function authcode($string, $operation = 'DECODE', $key = 'encrypt', $expiry = 0)
    {
        // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $ckey_length = 4;
        // 密匙
        $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
        // 密匙a会参与加解密
        $keya = md5(substr($key, 0, 16));
        // 密匙b会用来做数据完整性验证
        $keyb = md5(substr($key, 16, 16));
        // 密匙c用于变化生成的密文
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
            substr(md5(microtime()), -$ckey_length)) : '';
        // 参与运算的密匙
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
        //解密时会通过这个密匙验证数据完整性
        // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
            sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        // 产生密匙簿
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            // 从密匙簿得出密匙进行异或，再转成字符
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            // 验证数据有效性，请看未加密明文的格式
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)
            ) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
            // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

    /**
     * @param STRING $string 要加密/解密的字符串
     * @param  STRING $operation 类型，E 加密；D 解密
     * @param string $key 密钥
     * @return mixed|string
     */
    static function encrypt($string, $operation, $key = 'encrypt')
    {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
                return substr($result, 8);
            } else {
                return '';
            }
        } else {
            return str_replace('=', '', base64_encode($result));
        }
    }


    static function authcode2($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $ckey_length = 4;

// 密匙
        $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);

// 密匙a会参与加解密
        $keya = md5(substr($key, 0, 16));
// 密匙b会用来做数据完整性验证
        $keyb = md5(substr($key, 16, 16));
// 密匙c用于变化生成的密文
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
            substr(md5(microtime()), -$ckey_length)) : '';
// 参与运算的密匙
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
//解密时会通过这个密匙验证数据完整性
// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
// 产生密匙簿
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
// 核心加解密部分
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
// 从密匙簿得出密匙进行异或，再转成字符
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
// 验证数据有效性，请看未加密明文的格式
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }


}