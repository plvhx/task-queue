# Task Queue

## Task queue library written in PHP.

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