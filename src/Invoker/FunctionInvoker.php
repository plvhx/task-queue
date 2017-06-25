<?php

namespace TaskQueue\Invoker;

use TaskQueue\Invoker\Exception\InvalidCallableTypeException;

class FunctionInvoker implements InvokerInterface
{
    /**
     * @var \Closure|string
     */
    private $function;

    public function __construct($function)
    {
        if (!is_callable($function) && !($function instanceof \Closure)) {
            throw new InvalidCallableTypeException(
                sprintf("Parameter 1 of %s must be a valid callback or exist function name.", __METHOD__)
            );
        }

        $this->function = $function;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke()
    {
        return call_user_func_array($this->function, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function invokeWithArgs($args)
    {
        if (!is_array($args)) {
            throw new \InvalidArgumentException(
                sprintf("Parameter 1 of %s must be an array of required function arguments.", __METHOD__)
            );
        }

        return call_user_func_array($this->function, $args);
    }
}
