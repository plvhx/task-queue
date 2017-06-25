<?php

namespace TaskQueue\Invoker;

interface InvokerInterface
{
    public function invoke();

    public function invokeWithArgs($args);
}
