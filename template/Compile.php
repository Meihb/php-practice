<?php

/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-13
 * Time: 15:27
 */
class Compile
{
    private $template;//待编译文件
    private $content;//需要替换的文本
    private $comfile;//编译后的文件
    private $left = '{';//左定界符
    private $right = '}';//右定界符
    private $value = [];//值栈

    public function __construct()
    {
    }

    public function compile($source, $destFile)
    {
        file_put_contents($destFile, file_get_contents($source));
    }

    public function c_var()
    {
        $patten = "#\P{\\$([a-zA-z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}#";
        if(strpos($this->content,'{$}'!==false)){
            $this->content = preg_replace($patten,
                "<?php echo \$this->value['\\1']; ?>",
                $this->content);
        }
    }
}