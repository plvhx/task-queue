<?php

declare(strict_types=1);

namespace TaskQueue\Tests\Fixtures\Invokable;

class Bar
{
	public function __invoke(...$args)
	{
		echo sprintf('this is (%s)' . PHP_EOL, __METHOD__);
	}
}
