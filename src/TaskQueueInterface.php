<?php

namespace TaskQueue;

interface TaskQueueInterface
{
    /**
     * Add callbacks or \Closure into task queueing stack.
     *
     * @param string $task The callback or Closure.
     * @param array $taskArgs The callback or Closure arguments.
     * @return TaskQueueInterface
     */
    public function add($task, $taskArgs = []);

    /**
     * Invoke all of pending task in the task queueing stack.
     *
     * @return void
     */
    public function run();
}
