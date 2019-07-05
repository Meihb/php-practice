<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/5
 * Time: 9:52
 */
//禁用错误报告
error_reporting(0);
//报告运行时错误
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//报告所有错误
error_reporting(E_ALL);

trait  ThrottlesLogins
{
    protected function test()
    {

    }
}

//function a1()
//{
//    echo "hello";
//}
//
//$a = "a1";
//$a();

class A
{
    function __construct($val)
    {
        $this->val = $val;
    }

    function getClosure()
    {
        //returns closure bound to this object and scope
        return function () {
            return $this->val;
        };
    }
}

$ob1 = new A(1);
$ob2 = new A(2);

$cl = $ob1->getClosure();
var_dump($cl instanceof Closure);
echo $cl(), "\n";
$cl = $cl->bindTo($ob2);//切换
echo $cl(), "\n";

/**
 * 复制一个闭包，绑定指定的$this对象和类作用域。
 *
 * @author 疯狂老司机
 */
class Animal
{
    public static $cat = "cat";
    public $dog = "dog";
    public $pig = "pig";
}

/*
 * 获取Animal类静态私有成员属性
 */
$cat = static function () {
    return static::$cat;
};

/*
 * 获取Animal实例私有成员属性
 */
$dog = function () {
    var_dump(static::$cat);
    return $this->dog;
};

/*
 * 获取Animal实例公有成员属性
 */
$pig = function () {
    var_dump(static::$cat);
    return $this->pig;
};

//一个访问$this ,一个访问static???
$bindCat = Closure::bind($cat, null, new Animal());// 给闭包绑定了Animal实例的作用域，但未给闭包绑定$this对象
$bindDog = Closure::bind($dog, new Animal(), 'Animal');// 给闭包绑定了Animal类的作用域，同时将Animal实例对象作为$this对象绑定给闭包
$bindPig = Closure::bind($pig, new Animal());// 将Animal实例对象作为$this对象绑定给闭包,保留闭包原有作用域
echo $bindCat(), '<br>';// 根据绑定规则，允许闭包通过作用域限定操作符获取Animal类静态私有成员属性
echo $bindDog(), '<br>';// 根据绑定规则，允许闭包通过绑定的$this对象(Animal实例对象)获取Animal实例私有成员属性
echo $bindPig(), '<br>';// 根据绑定规则，允许闭包通过绑定的$this对象获取Animal实例公有成员属性


//docker 好像必须是登录状态下载