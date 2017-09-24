<?php

namespace TaskQueue\Invoker;

use DependencyInjection\Container;
use TaskQueue\Invoker\Exception\ArrayPairLengthAwareException;
use TaskQueue\Invoker\Exception\ClassInstanceException;
use TaskQueue\Invoker\Exception\ClassMethodException;

class MethodInvoker implements InvokerInterface
{
    /**
     * @var array
     */
    private $method;

    public function __construct($args)
    {
        if (!is_array($args)) {
            throw new \InvalidArgumentException(
                sprintf("Parameter 1 of %s must be an array.", __METHOD__)
            );
        }

        if (sizeof($args) !== 2) {
            throw new ArrayPairLengthAwareException(
                sprintf("Parameter 1 of %s must be an array with length === 2.", __METHOD__)
            );
        }

        if (!isset($args['instance'])) {
            throw new ClassInstanceException("\$args index key 'instance' must exists.");
        }

        if (!isset($args['method'])) {
            throw new ClassMethodException("\$args index key 'method' must exists.");
        }

        $args['instance'] = (!is_object($args['instance'])
            ? (class_exists($args['instance'])
                ? (new Container)->make($args['instance'])
                : null)
            : $args['instance']);

        $this->method = $args;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke()
    {
        return call_user_func_array(
            [$this->method['instance'], $this->method['method']], func_get_args()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function invokeWithArgs($args)
    {
        if (!is_array($args)) {
            throw new \InvalidArgumentException(
                sprintf("Parameter 1 of %s must be an array.", __METHOD__)
            );
        }

        return call_user_func_array(
            [$this->method['instance'], $this->method['method']], $args
        );
    }
}
