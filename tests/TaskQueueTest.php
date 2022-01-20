<?php

namespace TaskQueue\Tests;

use InvalidArgumentException;
use SplFixedArray;
use PHPUnit\Framework\TestCase;
use TaskQueue\TaskQueue;
use TaskQueue\Invoker\FunctionInvoker;
use TaskQueue\Tests\Fixtures\Invokable\Foo as FooInvokable;
use TaskQueue\Tests\Fixtures\Invokable\Bar as BarInvokable;
use TaskQueue\Tests\Fixtures\Vanilla\Foo as FooVanilla;
use TaskQueue\Tests\Fixtures\Vanilla\Bar as BarVanilla;

/**
 * @covers TaskQueue\TaskQueue
 */
class TaskQueueTest extends TestCase
{
    use TaskQueueTestTrait;

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(TaskQueue::class, new TaskQueue());
    }

    public function testCanRegisterFunctionBasedSingleTask()
    {
        $taskQueue = new TaskQueue();
        $taskQueue->add('printf', '%d' . PHP_EOL, 31337);

        $this->startOutputBuffering();
        $taskQueue->run();
        $this->endOutputBuffering();

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

        $this->startOutputBuffering();
        $taskQueue->run();
        $this->endOutputBuffering();

        $this->assertTrue(true);
    }

    public function testCanRegisterMethodBasedSingleTask()
    {
        $taskQueue = new TaskQueue();
        $taskQueue->add([new SplFixedArray(), 'count']);

        $this->startOutputBuffering();
        $taskQueue->run();
        $this->endOutputBuffering();

        $this->assertTrue(true);
    }

    public function testCanRegisterInvokableObjectBasedTasks()
    {
        $taskQueue = new TaskQueue();
        $taskQueue->add(new FooInvokable());
        $taskQueue->add(new BarInvokable());

        $this->startOutputBuffering();
        $taskQueue->run();
        $this->endOutputBuffering();

        $this->assertTrue(true);
    }

    public function testCanRegisterVanillaObjectBasedTasks()
    {
        $taskQueue = new TaskQueue();
        $taskQueue->add([new FooVanilla(), 'run']);
        $taskQueue->add([new BarVanilla(), 'run']);

        $this->startOutputBuffering();
        $taskQueue->run();
        $this->endOutputBuffering();

        $this->assertTrue(true);
    }

    public function testCanThrowExceptionWhenRegisteringAnInvalidTask()
    {
        $this->expectException(InvalidArgumentException::class);

        $taskQueue = new TaskQueue();
        $taskQueue->add(true);
    }

    public function testCanSetTasks()
    {
        $taskQueue = new TaskQueue();
        $taskQueue->setTasks([
            [new FunctionInvoker('file_get_contents'), ['/etc/passwd']],
            [new FunctionInvoker('passthru'), ['ls -l']]
        ]);
        $this->assertEquals(2, count($taskQueue->getTasks()));
    }
}
