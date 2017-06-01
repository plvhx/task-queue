<?php

namespace TaskQueue;

class TaskQueue implements TaskQueueInterface
{
    /**
     * @var array
     */
    private $tasks = [];

    /**
     * Add callbacks or \Closure into task queueing stack.
     *
     * @param string $task The callback or Closure.
     * @param array $taskArgs The callback or Closure arguments.
     * @return TaskQueueInterface
     */
    public function add($task, $taskArgs = [])
    {
        if (!is_callable($task) && !($task instanceof \Closure)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Parameter 1 of %s must be instance of \\Closure or name of function that exists.", __METHOD__
                )
            );
        }

        $taskArgs = (is_array($taskArgs) ? $taskArgs : array_slice(func_get_args(), 1));

        array_unshift($this->tasks, compact('task', 'taskArgs'));

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
            call_user_func_array($eachTasks['task'], $eachTasks['taskArgs']);
        }
    }
}
