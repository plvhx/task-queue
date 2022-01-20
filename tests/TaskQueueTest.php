<?php

namespace TaskQueue\Tests;

use SplFixedArray;
use PHPUnit\Framework\TestCase;
use TaskQueue\TaskQueue;

class TaskQueueTest extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(TaskQueue::class, new TaskQueue());
    }
    
    public function testCanRegisterFunctionBasedSingleTask()
    {
        $taskQueue = new TaskQueue();
        $taskQueue->add('printf', '%d' . PHP_EOL, 31337);
        $taskQueue->run();
        $this->assertTrue(true);
    }

    public function testCanRegisterFunctionBasedMultipleTasks()
    {
        $taskQueue = new TaskQueue();
        $taskQueue
            ->add('printf', '%d' . PHP_EOL, 31337)
            ->add(function ($filename) {
                    echo sprintf("%s", file_get_contents($filename));
                }, '/etc/passwd');
        $taskQueue->run();
        $this->assertTrue(true);
    }

    public function testCanRegisterMethodBasedSingleTask()
    {
        $taskQueue = new TaskQueue();
        $taskQueue
            ->add([new SplFixedArray(), 'count']);
        $taskQueue->run();
        $this->assertTrue(true);
    }
}
