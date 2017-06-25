<?php

namespace TaskQueue;

use TaskQueue\Invoker\InvokerInterface;

class TaskQueue implements TaskQueueInterface
{
    /**
     * @var array
     */
    private $tasks = [];

    /**
     * Add callbacks or \Closure into task queueing stack.
     *
     * @param InvokerInterface $invoker
     * @param array $taskArgs The callback or Closure arguments.
     * @return TaskQueueInterface
     */
    public function add(InvokerInterface $invoker, $taskArgs = [])
    {
        $taskArgs = (is_array($taskArgs) ? $taskArgs : array_slice(func_get_args(), 1));

        array_unshift($this->tasks, compact('invoker', 'taskArgs'));

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
}
