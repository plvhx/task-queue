<?php

declare(strict_types=1);

namespace TaskQueue\Invoker;

use function call_user_func_array;
use function func_get_args;

/**
 * @author Paulus Gandung Prakosa <gandung@lists.infradead.org>
 */
class MethodInvoker implements InvokerInterface
{
    use InvokableTrait;

    /**
     * @param array $args
     * @return static
     */
    public function __construct(array $args)
    {
        $this->setInvokable($args);
    }

    /**
     * {@inheritdoc}
     */
    public function invoke()
    {
        return call_user_func_array(
            [$this->getInvokableObject(), $this->getInvokableMethod()], func_get_args()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function invokeWithArgs(array $args)
    {
        return call_user_func_array(
            [$this->getInvokableObject(), $this->getInvokableMethod()], $args
        );
    }

    /**
     * @return object
     */
    private function getInvokableObject(): object
    {
        return $this->getInvokable()[0];
    }

    /**
     * @return string
     */
    private function getInvokableMethod(): string
    {
        return $this->getInvokable()[1];
    }
}
