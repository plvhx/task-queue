# Task Queue

## Task queue library written in PHP.

[![Coverage Status](https://coveralls.io/repos/github/plvhx/task-queue/badge.svg?branch=master)](https://coveralls.io/github/plvhx/task-queue?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8d81bd99-56ad-4635-9236-f65497ea3881/small.png)](https://insight.sensiolabs.com/projects/8d81bd99-56ad-4635-9236-f65497ea3881)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/plvhx/task-queue/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/plvhx/task-queue/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/plvhx/task-queue/badges/build.png?b=master)](https://scrutinizer-ci.com/g/plvhx/task-queue/build-status/master)

## Registering single task

Existing functions or callbacks:

```php
<?php

$taskQueue = new TaskQueue;

$taskQueue->add('file_get_contents', '/etc/passwd');

$taskQueue->run();
```

Closures:

```php
<?php

$taskQueue = new TaskQueue;

$taskQueue->add(function() { echo "Hello with closures." . PHP_EOL; });

$taskQueue->run();
```

## Registering multiple tasks

Existing functions or callbacks:

```php
<?php

$taskQueue = new TaskQueue;

$taskQueue
	->add('file_get_contents', '/etc/passwd')
	->add('printf', '%d' . PHP_EOL, 31337);

$taskQueue->run();
```

Closures:

```php
<?php

$taskQueue = new TaskQueue;

$taskQueue
	->add(function() { echo "This will be a second run." . PHP_EOL; })
	->add(function() { echo "This will be a first run." . PHP_EOL; });

$taskQueue->run();
```

## Unit testing

```
vendor/bin/phpunit
```
