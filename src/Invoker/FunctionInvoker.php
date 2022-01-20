<?php

declare(strict_types=1);

namespace TaskQueue\Invoker;

use InvalidArgumentException;

use function call_user_func_array;
use function func_get_args;
use function is_array;
use function sprintf;

/**
 * @author Paulus Gandung Prakosa <gandung@lists.infradead.org>
 */
class FunctionInvoker implements InvokerInterface
{
    use InvokableTrait;

    /**
     * @param mixed $function
     * @return static
     */
    public function __construct($function)
    {
        $this->setInvokable($function);
    }

    /**
     * {@inheritdoc}
     */
    public function invoke()
    {
        return call_user_func_array($this->getInvokable(), func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function invokeWithArgs(array $args)
    {
        return call_user_func_array($this->getInvokable(), $args);
    }
}
