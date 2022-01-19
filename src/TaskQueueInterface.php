<?php

namespace TaskQueue;

use TaskQueue\Invoker\InvokerInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@lists.infradead.org>
 */
interface TaskQueueInterface
{
    /**
     * Add callbacks or \Closure into task queueing stack.
     *
     * @param mixed $callback
     * @param array $args
     * @return TaskQueueInterface
     */
    public function add($callback, $args = []);

    /**
     * Invoke all of pending task in the task queueing stack.
     *
     * @return void
     */
    public function run();

    /**
     * @param array $tasks
     * @return static
     */
    public function setTasks(array $tasks);

    /**
     * @return array
     */
    public function getTasks(): array;

    /**
     * @param array $task
     * @return static
     */
    public function addTask(array $task);
}
