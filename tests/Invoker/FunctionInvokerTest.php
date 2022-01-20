<?php

namespace TaskQueue\Tests\Invoker;

use PHPUnit\Framework\TestCase;
use TaskQueue\Invoker\FunctionInvoker;
use TaskQueue\Invoker\Exception\InvalidCallableTypeException;

class FunctionInvokerTest extends TestCase
{
	public function testShit()
	{
		$this->assertTrue(true);
	}
}
