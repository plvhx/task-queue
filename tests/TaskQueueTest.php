<?php

namespace TaskQueue\Tests;

use TaskQueue\TaskQueue;
use TaskQueue\Invoker\FunctionInvoker;
use TaskQueue\Invoker\MethodInvoker;

class TaskQueueTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGetInstance()
    {
        $taskQueue = new TaskQueue;

        $this->assertInstanceOf(TaskQueue::class, $taskQueue);
    }
    
    public function testCanRegisterFunctionBasedSingleTask()
    {
        $taskQueue = new TaskQueue;

        $taskQueue->add(new FunctionInvoker('printf'), '%d' . PHP_EOL, 31337);

        $taskQueue->run();
    }

    public function testCanRegisterFunctionBasedMultipleTasks()
    {
        $taskQueue = new TaskQueue;

        $taskQueue
            ->add(new FunctionInvoker('printf'), '%d' . PHP_EOL, 31337)
            ->add(new FunctionInvoker(function ($filename) {
                echo sprintf("%s", file_get_contents($filename));
            }), '/etc/passwd');

        $taskQueue->run();
    }
}
