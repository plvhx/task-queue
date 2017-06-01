<?php

namespace TaskQueue\Tests;

use TaskQueue\TaskQueue;

class TaskQueueTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGetInstance()
    {
        $taskQueue = new TaskQueue;

        $this->assertInstanceOf(TaskQueue::class, $taskQueue);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCanThrowExceptionWhileRegisteringTasks()
    {
        $taskQueue = new TaskQueue;

        $taskQueue->add(null);
    }

    public function testCanRegisterSingleTask()
    {
        $taskQueue = new TaskQueue;

        $taskQueue->add('printf', '%d' . PHP_EOL, 31337);

        $taskQueue->run();
    }

    public function testCanRegisterMultipleTasks()
    {
        $taskQueue = new TaskQueue;

        $taskQueue
            ->add('printf', '%d' . PHP_EOL, 31337)
            ->add(function ($filename) {
                echo sprintf("%s", file_get_contents($filename));
            }, '/etc/passwd');

        $taskQueue->run();
    }
}
