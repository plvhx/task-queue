<?php

namespace TaskQueue\Tests\Invoker;

use TaskQueue\Invoker\FunctionInvoker;
use TaskQueue\Invoker\Exception\InvalidCallableTypeException;

class FunctionInvokerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGetInstance()
    {
        $invoker = new FunctionInvoker(function ($q) {
            return "This is a dummy return value.";
        });

        $this->assertInstanceOf(FunctionInvoker::class, $invoker);
    }

    /**
     * @expectedException TaskQueue\Invoker\Exception\InvalidCallableTypeException
     */
    public function testCannotGetInstanceAndThrowsException()
    {
        $invoker = new FunctionInvoker(null);
    }

    public function testCanInvokeCallableWithBuiltinPHPArgumentGetter()
    {
        $invoker = new FunctionInvoker('file_get_contents');

        $this->assertInstanceOf(FunctionInvoker::class, $invoker);
        $this->assertInternalType('string', $invoker->invoke('/etc/passwd', FILE_USE_INCLUDE_PATH));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCannotInvokeCallableAndThrowsException()
    {
        $invoker = new FunctionInvoker('file_get_contents');

        $this->assertInstanceOf(FunctionInvoker::class, $invoker);
        $this->assertInternalType('string', $invoker->invokeWithArgs('/etc/passwd', FILE_USE_INCLUDE_PATH));
    }

    public function testCanInvokeCallableWithArrayOfArguments()
    {
        $invoker = new FunctionInvoker('file_get_contents');

        $this->assertInstanceOf(FunctionInvoker::class, $invoker);
        $this->assertInternalType('string', $invoker->invokeWithArgs(['/etc/passwd', FILE_USE_INCLUDE_PATH]));
    }
}
