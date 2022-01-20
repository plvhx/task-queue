<?php

declare(strict_types=1);

namespace TaskQueue;

use Closure;
use InvalidArgumentException;
use TaskQueue\Invoker\FunctionInvoker;
use TaskQueue\Invoker\MethodInvoker;
use TaskQueue\Invoker\InvokerInterface;

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
        } catch (InvalidArgumentException $e) {
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
            $eachTasks[0]->invokeWithArgs($eachTasks[1]);
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

    /**
     * @param mixed $callable
     * @return \TaskQueue\Invoker\InvokerInterface
     * @throws InvalidArgumentException When callable parameter is invalid.
     */
    private function checkAndAssign($callable): InvokerInterface
    {
        if (is_array($callable) &&
            count($callable) == 2 &&
            (is_object($callable[0]) && method_exists($callable[0], $callable[1]))) {
            return new MethodInvoker($callable);
        }

        if (is_callable($callable) || is_a($callable, Closure::class)) {
            return new FunctionInvoker($callable);
        }

        throw new InvalidArgumentException(
            'Callable must be function or instance of \\Closure or invokable class object or ' .
            'pair of class object and its supplied method name that exist within.'
        );
    }
}
