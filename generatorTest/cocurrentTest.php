<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/6/25
 * Time: 10:05
 */

function printer()
{
    $i = 0;
    while (true) {
        echo "receive:" . (yield++$i) . "<br>";
        if ($i = 3) {
            return $i;
        }
    }
}

$printer = printer();

echo 'current is ' . $printer->current() . "<br>";
$printer->send("hello");//Sends the given value to the generator as the result of the current yield expression g
echo 'current is ' . $printer->current() . "<br>";
$printer->send("world");
echo 'current is ' . $printer->current() . "<br>";
var_dump($printer->getReturn());//once it`s finished


function nums()
{
    for ($i = 0; $i < 5; $i++) {
        $cmd = yield $i;
        if ($cmd == 'stop') {
            return "EOF";
        }
    }
}

$gen = nums();
foreach ($gen as $num) {
    if ($num == 3) {
        $gen->send("stop");
    }
    echo "{$num} \n";
}

//协程案例
function logger($fileName)
{
    $handle = fopen($fileName, "w+");
    while (true) {
        sleep(1);
        $info = yield date("Y-m-d H:i:s") . "\r\n";
        echo $info;
        fwrite($handle, $info);
    }
}

/*
echo "<br>";
$logger = logger(__DIR__ . "/log");
echo "value is " . $logger->current() . "<br>";
$logger->next();
echo "value is " . $logger->current() . "<br>";
$logger->send("Foo\r\n");
echo "value is " . $logger->current() . "<br>";
$logger->send("Bar\r\n");
echo "value is " . $logger->current() . "<br>";
*/

function gen()
{
    echo "initiate<br>";
    $ret = yield "yield1";
    echo "yield 1  after<br>";
    var_dump($ret);
    $ret = yield"yield2";
    echo "yield 2 after <br>";
    var_dump($ret);
}
//看起来,GENERATOIR 每次迭代时 先处理完yielded value(key=>value)在将表达式整体挂起,等待next或者send(equal to next with null as argument ，but return with different)，在走之下一次yield
//即可以认为,两个逻辑流程,生成器自我处理 yielded key value,而用户操作程序处理expression
echo "<br>";
$gen = gen();
echo "current<br>";
var_dump($gen->current());//yield1 首个yielded value必须通过current获取,用send会导致第一个yieded value被跳过
echo "send(ret1)<br>";
var_dump($gen->send("ret1"));// string(4) "ret1"   (the first var_dump in gen)
                                // string(6) "yield2" (the var_dump of the ->send() return value) Returns the yielded value.此步骤很关键,承上启下,yield2需思考清楚
echo "current<br>";
var_dump($gen->current());
echo "send(ret2)<br>";
var_dump($gen->send("ret2"));// string(4) "ret2"   (again from within gen)
                                // NULL               (the return value of ->send())