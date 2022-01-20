<?php

declare(strict_types=1);

namespace TaskQueue\Tests\Fixtures\Vanilla;

class Foo implements VanillaInterface
{
	public function run()
	{
		echo sprintf('this is (%s)' . PHP_EOL, __METHOD__);
	}
}
