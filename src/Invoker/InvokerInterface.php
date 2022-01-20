<?php

declare(strict_types=1);

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
    public function invokeWithArgs(array $args);

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
