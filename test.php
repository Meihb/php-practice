<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-8-30
 * Time: 11:15
 */

/*
 * 查看php的牧师方法,主要是__set,__get,__call,__callStatic,尝试动态绑定
 */

abstract class  ActiveRecord
{
    protected static $table;
    protected $fieldvaues;
    public $select;

    static function findById($id)
    {
        $query = "select * from " . static::$table .
            " where id =" . $id;
        return self::createDomain($query);
    }

    function __get($fildname)
    {
//        if (isset($this->fieldvaues[$fildname])) {
        return $this->fieldvaues[$fildname];
//        } else {
//            return 'null';
//        }

    }

    function __call($name, $arguments)
    {
        var_dump('this is call');
    }

    static function __callStatic($method, $args)
    {
        var_dump('this is method ' . $method, $args);
        $field = preg_replace('/^findBy(\w*)$/', '${1}', $method);
        var_dump('this is field ' . $field);
        $query = "select * from"
            . static::$table .
            " where $field ='$args[0]'";
        return self::createDomain($query);
    }

    private static function createDomain($query)
    {
        $klass = get_called_class();
        $domain = new $klass();
        $domain->fieldvalues = [];
        $domain->select = $query;
        foreach ($klass::$fields as $field => $type) {
            $domain->fieldvalues[$field] = 'TODO: set from sql result';
        }
        return $domain;
    }

    public function chained()
    {
        var_dump('here');
        return $this;
    }
}

class Customer extends ActiveRecord
{
    protected static $table = 'custdb';
    protected static $fields = [
        'id' => 'int',
        'email' => 'varchar',
        'lastname' => 'varchar',
    ];
}

class Sales extends ActiveRecord
{
    protected static $table = 'salesdb';
    protected static $fields = [
        'id' => 'int',
        'item' => 'varchar',
        'qty' => 'int',
    ];
}


//assert("select * from custdb where id =123" == Customer::findById(123)->select);
//assert("TODO:set from sql result " == Customer::findById(123)->email);
//assert("select * from salesdb where id =123" == Sales::findById(123)->select);
//assert("select * from custdb WHERE  Lastname = 'Denoncourt'" == Customer::findByLastname('Denoncourt')->select);

/*
 * static 和 self的区别
 * static当属性成员被覆盖时会访问最子的值,self是根据当前语法在哪一个方法中被创建,那么该self就特指其代码空间
 */

class Vehicle1
{
    protected static $name = 'This is a Vehicle';

    public static function what_vehicle()
    {
        echo get_called_class() . "\n";
        echo self::$name;
        echo "\r\n" . "<br>";
        echo __CLASS__ . "<br>";
    }
}

class Sedan1 extends Vehicle1
{
    protected static $name = 'This is a Sedan1' . "\r\n";
}

class Vehicle2
{
    protected static $name = 'This is a Vehicle' . "\r\n";

    public static function what_vehicle()
    {
        echo get_called_class() . "\n";
        echo static::$name;
        echo "\r\n";
    }
}

class Sedan2 extends Vehicle2
{
    protected static $name = 'This is a Sedan2' . "\r\n";
}

//Sedan1::what_vehicle();//Sedan1 This is a Vehicle
//Sedan2::what_vehicle();//Sedan2 This is a Sedan


/*
 * 继承与多态
 * parent 关键字仅适用于 方法,或者静态属性
 */

class people
{
    static $money = 10;
}

class person extends people
{
    public $name = 'Tom';
    public $gender = 'male';
    static $money = 100;

    public function __construct()
    {
        echo 'this is 父类' . PHP_EOL;
    }

    public function say()
    {
        echo self::$money . PHP_EOL;
        echo $this->name . "\tis " . $this->gender . PHP_EOL;
    }
}

class family extends person
{
//    public $name;//倘若重新申明属性 即是 对 属性重写
//    public $gender;
    static $money = 1000;


    public function __construct()
    {
        parent::__construct();

        echo 'this is 子类' . PHP_EOL;

    }

    public function __set($name, $value)
    {
        if (isset($this->$name)) {
            $this->$name = $value;
        } else {
            $this->$name = $value;
//            echo 'invalid property';
        }
    }


    public function say()
    {
        echo parent::$money . PHP_EOL;
        echo static::$money;

        parent::say();
    }


}

//$poor = new family();
//echo $poor->name . PHP_EOL;
//$poor->say();
function decode($buffer)
{

    $len = $masks = $data = $decoded = null;
    $len = ord($buffer[1]) & 127;

    if ($len === 126) {
        $masks = substr($buffer, 4, 4);
        $data = substr($buffer, 8);
    } else if ($len === 127) {
        $masks = substr($buffer, 10, 4);
        $data = substr($buffer, 14);
    } else {
        $masks = substr($buffer, 2, 4);
        $data = substr($buffer, 6);
    }
    for ($index = 0; $index < strlen($data); $index++) {
        $decoded .= $data[$index] ^ $masks[$index % 4];
    }
    return $decoded;
}

function frame($s)
{
    $a = str_split($s, 125);
    if (count($a) == 1) {
        return "\x81" . chr(strlen($a[0])) . $a[0];
    }
    $ns = "";
    foreach ($a as $o) {
        $ns .= "\x81" . chr(strlen($o)) . $o;
    }
    return $ns;
}

//$txt = 'hello world';
//var_dump(frame($txt));

function quote(&$a)
{//应用传值的值无需预先创建
    $a = 4;
    $a = $a + 1;
    return $a;
}

//$a = 5;
//echo $a;
//quote($a);
//echo $a;


function testsyanx()
{
    $name1 = 'mhb';
    $situation = false;
    $situation or exit($name1);
}

//testsyanx();


function testStack()
{
    $stack = new SplStack();
    $stack->setIteratorMode(SplStack::IT_MODE_LIFO | SplStack::IT_MODE_DELETE);

    $stack->push(1);
    $stack->push(2);
    var_dump($stack);

    var_dump($stack->pop());

    var_dump($stack);
}

//testStack();
function testQueue()
{
    $queue = new SplQueue();
    $queue->setIteratorMode(SplStack::IT_MODE_FIFO | SplStack::IT_MODE_DELETE);

    $queue->enqueue(1);
    $queue->enqueue(2);
    var_dump($queue);

    var_dump($queue->dequeue());

    var_dump($queue);
}

testQueue();
