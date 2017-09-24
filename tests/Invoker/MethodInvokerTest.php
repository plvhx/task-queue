<?php

namespace TaskQueue\Tests\Invoker;

use DependencyInjection\Container;
use TaskQueue\Invoker\MethodInvoker;
use TaskQueue\Invoker\Exception\ArrayPairLengthAwareException;
use TaskQueue\Invoker\Exception\ClassInstanceException;
use TaskQueue\Invoker\Exception\ClassMethodException;

class MethodInvokerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGetInstance()
    {
        $invoker = new MethodInvoker(
            ['instance' => \SplPriorityQueue::class, 'method' => 'count']
        );

        $this->assertInstanceOf(MethodInvoker::class, $invoker);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCannotGetInstanceAndThrowsException0()
    {
        $invoker = new MethodInvoker(null);
    }

    /**
     * @expectedException \TaskQueue\Invoker\Exception\ArrayPairLengthAwareException
     */
    public function testCannotGetInstanceAndThrowsException1()
    {
        $invoker = new MethodInvoker([]);
    }

    /**
     * @expectedException \TaskQueue\Invoker\Exception\ClassInstanceException
     */
    public function testCannotGetInstanceAndThrowsException2()
    {
        $invoker = new MethodInvoker([\SplPriorityQueue::class, 'method' => 'count']);
    }

    /**
     * @expectedException \TaskQueue\Invoker\Exception\ClassMethodException
     */
    public function testCannotGetInstanceAndThrowsException3()
    {
        $invoker = new MethodInvoker(['instance' => \SplPriotiyQueue::class, 'count']);
    }

    public function testCanInvokeMethodWithPHPBuiltinArgumentGetter()
    {
        $invoker = new MethodInvoker(
            ['instance' => \SplPriorityQueue::class, 'method' => 'count']
        );

        $this->assertInstanceOf(MethodInvoker::class, $invoker);
        $this->assertInternalType('integer', $invoker->invoke());
        $this->assertEquals(0, $invoker->invoke());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCannotInvokeMethodAndThrowsException()
    {
        $invoker = new MethodInvoker(
            ['instance' => \SplPriorityQueue::class, 'method' => 'count']
        );

        $invoker->invokeWithArgs(null);
    }

    public function testCanInvokeMethodWithArrayOfArguments()
    {
        $invoker = new MethodInvoker(
            ['instance' => \SplPriorityQueue::class, 'method' => 'count']
        );

        $this->assertInstanceOf(MethodInvoker::class, $invoker);
        $this->assertInternalType('integer', $invoker->invokeWithArgs([]));
        $this->assertEquals(0, $invoker->invokeWithArgs([]));
    }
}
