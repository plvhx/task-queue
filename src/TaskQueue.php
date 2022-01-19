<?php

namespace TaskQueue;

use TaskQueue\Invoker\FunctionInvoker;
use TaskQueue\Invoker\InvokerInterface;
use TaskQueue\Invoker\MethodInvoker;

/**
 * @author Paulus Gandung Prakosa <gandung@lists.infradead.org>
 */
class TaskQueue implements TaskQueueInterface
{
    /**
     * @var array
     */
    private $tasks = [];

    /**
     * {@inheritdoc}
     */
    public function add($callable, $args = [])
    {
        try {
            $callable = $this->checkAndAssign($callable);
        } catch (Exception $e) {
            throw $e;
        }

        $args = (is_array($args)
            ? $args
            : array_slice(func_get_args(), 1));

        $this->addTask([$callable, $args]);
        return $this;
    }

    /**
     * Invoke all of pending task in the task queueing stack.
     *
     * @return void
     */
    public function run()
    {
        while ($eachTasks = array_shift($this->tasks)) {
            $eachTasks['invoker']->invokeWithArgs($eachTasks['taskArgs']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setTasks(array $tasks)
    {
        $this->tasks = $tasks;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * {@inheritdoc}
     */
    public function addTask(array $task)
    {
        $this->tasks[] = $task;
        return $this;
    }

    private function checkAndAssign($callable)
    {
        if (is_callable($callable) || is_a($callable, Closure::class)) {
            return new FunctionInvoker($callable);
        }

        if (is_object($callable) && method_exists($callable, '__invoke')) {
            return new FunctionInvoker($callable);
        }

        if (is_array($callable) &&
            count($callable) == 2 &&
            (is_object($callable[0]) && method_exists($callable[0], $callable[1]))) {
            return new MethodInvoker($callable);
        }
    }
}
