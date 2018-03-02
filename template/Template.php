<?php

/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-13
 * Time: 14:27
 */
class Template
{
    private $arrayConfig = [
        'suffix' => '.m',
        'templateDir' => 'template',//设置模板所在文件夹
        'compiledir' => 'cache/',//设置编译后存放的目录
        'cache_htm' => false,//设置是否需要编译成静态的html文件
        'suffix_cache' => '.htm',//设置编译文件的后缀
        'cache_time' => 7200,//设置自动时间更新,单位S
    ];
    public $file;//模板文件名
    private static $instance = null;
    private $value = [];
    private $compileTool;

    public function __construct($arrayConfig = [])
    {
        $this->arrayConfig = $this->arrayConfig + $arrayConfig;
        include_once "./Compile.php";
        $this->compileTool = new Compile();
    }

    /*
     * 取得模板引擎的实例
     * @return object
     * @access public
     * @static
     */
    public static function getInstance()
    {//单例化
        if (is_null(self::$instance)) {
            self::$instance = new Template();
        }
        return self::$instance;
    }

    /*
     * 单步设置引擎
     */
    public function setConfig($key, $value = null)
    {
        if (is_array($key)) {
            // 当下标为数值时，array_merge()不会覆盖掉原来的值，但array＋array合并数组则会把最先出现的值作为最终结果返回，而把后面的数组拥有相同键名的那些值“抛弃”掉（不是覆盖）.
            // 当下标为字符时，array＋array仍然把最先出现的值作为最终结果返回，而把后面的数组拥有相同键名的那些值“抛弃”掉，但array_merge()此时会覆盖掉前面相同键名的值.
            $this->arrayConfig = $key + $this->arrayConfig;
        } else {
            $this->arrayConfig[$key] = $value;
        }
    }

    /*
     * 获取当前模板引擎设置,仅供调试使用
     */
    public function getConfig($key = null)
    {
        if ($key) {
            return $this->arrayConfig[$key];
        } else {
            return $this->arrayConfig;
        }
    }

    /*
     * 注入单个变量
     * @param string $key 模板变量名
     * @param mixed $value 模板变量值
     * @return void
     */
    public function assign($key, $value)
    {
        $this->value[$key] = $value;
    }

    /*
     * 注入数组变量
     * @param array $array
     */
    public function assignArray($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $this->value[$key] = $value;
            }
        }
    }

    public function path()
    {
        return $this->arrayConfig['templateDir'] . '/' . $this->file . $this->arrayConfig['suffix'];
    }

    public function show($file)
    {
        $this->file = $file;
        if (!is_file($this->path())) {
            exit('找不到对应的模板文件');
        }
        $compileFile = $this->arrayConfig['compiledir'] . '/' . md5($file) . '.php';
        var_dump($compileFile);
        var_dump($this->path());

        if (!is_file($compileFile)) {
            if(!is_dir($this->arrayConfig['compiledir'])){
                mkdir($this->arrayConfig['compiledir']);
            }
            $this->compileTool->compile($this->path(), $compileFile);
        } else {
            readfile($compileFile);
        }
    }
}