<?php
///**
// * Created by PhpStorm.
// * User: meihaibo
// * Date: 2019/6/27
// * Time: 10:59
// */

class Task
{
    protected $taskId;
    protected $coroutine;
    protected $sendValue = null;
    protected $beforeFirstYield = true;

    public function __construct($taskId, Generator $coroutine)
    {
        $this->taskId = $taskId;
        $this->coroutine = $coroutine;
    }

    public function getTaskId()
    {
        return $this->taskId;
    }

    public function setSendValue($sendValue)
    {
        $this->sendValue = $sendValue;
    }

    public function run()
    {
        if ($this->beforeFirstYield) {
            $this->beforeFirstYield = false;
            return $this->coroutine->current();
        } else {
            $retval = $this->coroutine->send($this->sendValue);//yielded value
            $this->sendValue = null;
            return $retval;
        }
    }

    public function isFinished()
    {
        return !$this->coroutine->valid();
    }
}

class Scheduler
{
    protected $maxTaskId = 0;
    protected $taskMap = [];
    protected $taskQueue;

    public function __construct()
    {
        $this->taskQueue = new SplQueue(); //sqlqueue FIFO队列
    }

    public function newTask(Generator $coroutine)
    {
        $tid = ++$this->maxTaskId;
        $task = new Task($tid, $coroutine);
        $this->taskMap[$tid] = $task;
        $this->schedule($task);
        return $tid;
    }

    public function schedule(Task $task)
    {
        $this->taskQueue->enqueue($task);
    }

    public function killTask($tid)
    {
        if (!isset($this->taskMap[$tid])) {
            return false;
        }

        unset($this->taskMap[$tid]);

        // This is a bit ugly and could be optimized so it does not have to walk the queue,
        // but assuming that killing tasks is rather rare I won't bother with it now
        foreach ($this->taskQueue as $i => $task) {
            if ($task->getTaskId() === $tid) {
                unset($this->taskQueue[$i]);
                break;
            }
        }

        return true;
    }

    public function run()
    {
        while (!$this->taskQueue->isEmpty()) {
            $task = $this->taskQueue->dequeue();
            $retVal = $task->run();

            if ($retVal instanceof SystemCall) {
                //systemcall
                echo "systemcall<br>";
                $retVal($task, $this);
                continue;
            }
            if ($task->isFinished()) {
                unset($this->taskMap[$task->getTaskId()]);
            } else {
                $this->schedule($task);
            }
        }
    }

}

class SystemCall
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function __invoke(Task $task, Scheduler $scheduler)
        //实例化对象本身是不能被调用，但是类中如果实现 __invoke() 方法，则把实例对象当作方法调用，会自动调用到 __invoke() 方法，参数顺序相同
    {
        $callback = $this->callback;
        return $callback($task, $scheduler);
    }
}

//简单调用
/*
function task1()
{
    for ($i = 1; $i <= 10; $i++) {
        echo "This is task1 iteration $i <br>";
        yield;
    }
}

function task2()
{
    for ($i = 1; $i <= 5; $i++) {
        echo "This is task2 iteration $i<br>";
        yield;
    }
}

$scheduler = new Scheduler();
$scheduler->newTask(task1());
$scheduler->newTask(task2());

$scheduler->run();
*/

//系统调用
function getTaskId()
{
    return new SystemCall(function (Task $task, Scheduler $scheduler) {
        $task->setSendValue($task->getTaskId());
        $scheduler->schedule($task);
    });
}

//function task($max)
//{
//    $tid = (yield getTaskId()); // <-- here's the syscall!
//    for ($i = 1; $i <= $max; ++$i) {
//        echo "This is task $tid iteration $i.<br>";
//        yield;
//    }
//}

/*
$scheduler = new Scheduler;
$scheduler->newTask(task(10));
$scheduler->newTask(task(5));
$scheduler->run();
*/

//创建
function newTask(Generator $coroutine)
{
    return new SystemCall(
        function (Task $task, Scheduler $scheduler) use ($coroutine) {//use 从父作用域继承变量
            $task->setSendValue($scheduler->newTask($coroutine));
            $scheduler->schedule($task);
        }
    );
}

/**杀死任务
 * @param $tid
 * @return SystemCall
 */
function killTask($tid)
{
    return new SystemCall(
        function (Task $task, Scheduler $scheduler) use ($tid) {
            $task->setSendValue($scheduler->killTask($tid));
            $scheduler->schedule($task);
        }
    );
}

function childTask()
{
    $tid = (yield getTaskId());
    while (true) {
        echo "Child task $tid still alive<br>";
        yield;
    }
}

function task()
{
    $tid = (yield getTaskId());
    $childTid =
        (yield newTask(childTask()));

    for ($i = 1; $i <= 6; ++$i) {
        echo "Parent task $tid iteration $i<br>";
        yield;

        if ($i == 3)
            yield killTask($childTid);
    }
}

$scheduler = new Scheduler;
$scheduler->newTask(task());
$scheduler->run();
