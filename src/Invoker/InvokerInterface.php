<?php

namespace TaskQueue\Invoker;

/**
 * @author Paulus Gandung Prakosa <gandung@lists.infradead.org>
 */
interface InvokerInterface
{
    /**
     * @return void
     */
    public function invoke();

    /**
     * @param array $args
     * @return void
     */
    public function invokeWithArgs($args);

    /**
     * @return mixed
     */
    public function getInvokable();

    /**
     * @param mixed $invokable
     * @return void
     */
    public function setInvokable($invokable);
}
