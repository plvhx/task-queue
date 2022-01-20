<?php declare(strict_types=1);

namespace TaskQueue\Tests\Invoker;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TaskQueue\Invoker\FunctionInvoker;
use TaskQueue\Invoker\Exception\InvalidCallableTypeException;
use TaskQueue\Tests\TaskQueueTestTrait;
use TaskQueue\Tests\Fixtures\Invokable\Foo as FooInvokable;

use function file_get_contents;

/**
 * @covers TaskQueue\Invoker\FunctionInvoker
 */
class FunctionInvokerTest extends TestCase
{
	use TaskQueueTestTrait;

	public function testCanGetInstance()
	{
		$this->assertInstanceOf(FunctionInvoker::class, new FunctionInvoker('file_get_contents'));
	}

	public function testCanInvokeCallableBasedTask()
	{
		$invoker = new FunctionInvoker('file_get_contents');
		$invoker->invoke('/etc/passwd');
		$this->assertTrue(true);
	}

	public function testCanInvokeClosure()
	{
		$invoker = new FunctionInvoker(function() {
			echo file_get_contents('/etc/passwd');
		});

		$this->startOutputBuffering();
		$invoker->invoke();
		$this->endOutputBuffering();

		$this->assertTrue(true);
	}

	public function testCanInvokeInvokableObject()
	{
		$invoker = new FunctionInvoker(new FooInvokable());

		$this->startOutputBuffering();
		$invoker->invoke();
		$this->endOutputBuffering();

		$this->assertTrue(true);
	}

	public function testCanInvokeCallableBasedTaskWithArgs()
	{
		$invoker = new FunctionInvoker('file_get_contents');
		$invoker->invokeWithArgs(['/etc/passwd']);
		$this->assertTrue(true);
	}

	public function testCanInvokeClosureWithArgs()
	{
		$invoker = new FunctionInvoker(function($file) {
			echo file_get_contents($file);
		});

		$this->startOutputBuffering();
		$invoker->invokeWithArgs(['/etc/passwd']);
		$this->endOutputBuffering();

		$this->assertTrue(true);
	}

	public function testCanInvokeInvokableObjectWithEmptyArgs()
	{
		$invoker = new FunctionInvoker(new FooInvokable());

		$this->startOutputBuffering();
		$invoker->invokeWithArgs([]);
		$this->endOutputBuffering();

		$this->assertTrue(true);
	}

	public function testCanThrowExceptionWhenInvokableArgsIsInvalid()
	{
		$this->expectException(InvalidArgumentException::class);

		$invoker = new FunctionInvoker('file_get_contents');
		$invoker->invokeWithArgs(true);
	}
}
