<?php declare(strict_types=1);

namespace TaskQueue\Tests\Invoker;

use PHPUnit\Framework\TestCase;
use TaskQueue\Invoker\MethodInvoker;
use TaskQueue\Tests\TaskQueueTestTrait;
use TaskQueue\Tests\Fixtures\Vanilla\Foo as FooVanilla;

/**
 * @covers TaskQueue\Invoker\MethodInvoker
 */
class MethodInvokerTest extends TestCase
{
	use TaskQueueTestTrait;

	public function testCanGetInstance()
	{
		$this->assertInstanceOf(MethodInvoker::class, new MethodInvoker([new FooVanilla(), 'run']));
	}

	public function testCanInvokeCallablePair()
	{
		$invoker = new MethodInvoker([new FooVanilla(), 'run']);

		$this->startOutputBuffering();
		$invoker->invoke();
		$this->endOutputBuffering();

		$this->assertTrue(true);
	}

	public function testCanInvokeCallablePairWithEmptyArgs()
	{
		$invoker = new MethodInvoker([new FooVanilla(), 'run']);

		$this->startOutputBuffering();
		$invoker->invokeWithArgs([]);
		$this->endOutputBuffering();

		$this->assertTrue(true);
	}
}
