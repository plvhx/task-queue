### Task queue library written in PHP.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8d81bd99-56ad-4635-9236-f65497ea3881/small.png)](https://insight.sensiolabs.com/projects/8d81bd99-56ad-4635-9236-f65497ea3881)
[![Coverage Status](https://coveralls.io/repos/github/plvhx/task-queue/badge.svg?branch=master)](https://coveralls.io/github/plvhx/task-queue?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/plvhx/task-queue/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/plvhx/task-queue/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/plvhx/task-queue/badges/build.png?b=master)](https://scrutinizer-ci.com/g/plvhx/task-queue/build-status/master)

## Registering single task

Existing functions or callbacks:

```php
<?php

use TaskQueue\TaskQueue;
use TaskQueue\Invoker\FunctionInvoker;

$taskQueue = new TaskQueue;

$taskQueue->add(new FunctionInvoker('file_get_contents'), '/etc/passwd');

$taskQueue->run();
```

Closures:

```php
<?php

use TaskQueue\TaskQueue;
use TaskQueue\Invoker\FunctionInvoker;

$taskQueue = new TaskQueue;

$closure = function() {
	echo "Hello with closures." . PHP_EOL;
};

$taskQueue->add(new FunctionInvoker($closure));

$taskQueue->run();
```

Class method with class name:

```php
<?php

use TaskQueue\TaskQueue;
use TaskQueue\Invoker\MethodInvoker;

$taskQueue = new TaskQueue;

$taskQueue->add(new MethodInvoker(['instance' => \SplPriorityQueue::class, 'method' => 'count']));

$taskQueue->run();
```

Class method with class instance:

```php
<?php

use TaskQueue\TaskQueue;
use TaskQueue\Invoker\MethodInvoker;

$queue = new \SplPriorityQueue;
$taskQueue = new TaskQueue;

$taskQueue->add(new MethodInvoker(['instance' => $queue, 'method' => 'count']));

$taskQueue->run();
```

## Registering multiple tasks

Existing functions or callbacks:

```php
<?php

use TaskQueue\TaskQueue;
use TaskQueue\Invoker\FunctionInvoker;

$taskQueue = new TaskQueue;

$taskQueue
	->add(new FunctionInvoker('file_get_contents'), '/etc/passwd')
	->add(new FunctionInvoker('printf'), '%d' . PHP_EOL, 31337);

$taskQueue->run();
```

Closures:

```php
<?php

use TaskQueue\TaskQueue;
use TaskQueue\Invoker\FunctionInvoker;

$taskQueue = new TaskQueue;

$closures = [
	function() {
		echo "This will be a second run." . PHP_EOL;
	},
	function() {
		echo "This will be a first run." . PHP_EOL;
	}
];

$taskQueue
	->add(new FunctionInvoker($closures[0]))
	->add(new FunctionInvoker($closures[1]));

$taskQueue->run();
```

## Unit testing

```
vendor/bin/phpunit
```
