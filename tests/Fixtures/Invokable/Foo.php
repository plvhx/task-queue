<?php

namespace TaskQueue\Tests\Fixtures\Invokable;

declare(strict_types=1);

class Foo
{
	public function __invoke(...$args)
	{
		echo sprintf('this is (%s)' . PHP_EOL, __METHOD__);
	}
}
