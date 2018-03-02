<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-4
 * Time: 15:04
 */
/*
 * 反射api
 */

class person
{
    protected $father;
    public $name;//姓名
    public $gender;
    const  address = 'address';

    public function __construct()
    {
        if (isset($_SERVER)) {
//            echo 'protocal is ' . substr($_SERVER['SERVER_PROTOCOL'], 0, 4);
            if (substr($_SERVER['SERVER_PROTOCOL'], 0, 4) == 'HTTP') {
                echo "<pre>" . "\r\n";

            }
        }
    }

    public function say()
    {
        echo $this->name . "\t is  " . $this->gender . '\r\n';
    }

    public function __set($name, $value)
    {
        echo "Setting $name to $value \r\n";
        $this->$name = $value;
    }

    public function __get($name)
    {
        if (!isset($this->$name)) {
            echo '未设置';
            $this->$name = '正在设置默认值';
        }
        return $this->$name;
    }
}

$student = new person();
$student->name = 'Tom';
$student->gender = 'male';
$student->age = 24;

/********获取student对象的方法和属性列表*************/
//获取对象属性列表
$reflect = new ReflectionObject($student);
$props = $reflect->getProperties();
foreach ($props as $prop) {
    print $prop->getName() . "\r\n";
}
$methods = $reflect->getMethods();
foreach ($methods as $method) {
    print $method->getName() . "\r\n";
}
var_dump($reflect->getConstants());//获取constant
var_dump($reflect->getDocComment());//注释


//反射获取类的圆形
$obj = new ReflectionClass('person');
$className = $obj->getName();
$Methods = $Properties = [];
foreach ($obj->getProperties() as $property) {
    $Properties[$property->getName()] = $property;
}
foreach ($obj->getMethods() as $method) {
    $Methods[$method->getName()] = $method;
}

echo "class {$className} \n {\n";
is_array($Properties) && ksort($Properties);

foreach ($Properties as $k => $v) {
    echo "\t";
    echo $v->isPublic() ? 'public' : '', $v->isPrivate() ? 'private' : '', $v->isProtected() ? 'protected' : '', $v->isStatic() ? 'static' : '';
    echo "\t{$k}\n";
}

echo "\n";
if (is_array($Methods)) {
    ksort($Methods);
}

foreach ($Methods as $k => $v) {
    echo "\t function {$k}(){}\n";
}
echo "}\n";

class mysql
{
    function connect($db)
    {
        echo "连接到数据库{$db[0]}\r\n";
    }
}

/*********动态代理************/
class sqlproxy
{
    private $target;

    function __construct($tar)
    {
        $this->target[] = new $tar();
    }

    function __call($name, $arguments)
    {
        foreach ($this->target as $obj) {
            $r = new ReflectionObject($obj);
            if ($method = $r->getMethod($name)) {
                if ($method->isPublic() && !$method->isAbstract()) {
                    echo '方法前拦截记录' . "\r\n";
                    $method->invoke($obj, $arguments);
                    echo '方法后拦截' . "\r\n";
                }
            }
        }
    }
}

$obj = new sqlproxy('mysql');
$obj->connect('member');


/*************异常处理****************/
class testException
{
    function __set($name, $value)
    {
        $this->$name = $value;
    }

    function a()
    {
        throw new Exception('error a');
    }

    function b()
    {
        throw new Exception('error b');
    }

    function main()
    {
        try {
            $this->a();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        } finally {
            $this->error = '错了';
        }
    }
}

$obj = new testException();
$obj->main();
echo $obj->error;


/***********面向对象设计原则*********/
interface encode
{
    public function add();//形参是否在一定意义上就违背了抽象的概念啊
}

class myEncode implements encode
{
    public function add()
    {

    }
}


