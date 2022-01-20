<?php

declare(strict_types=1);

namespace TaskQueue\Tests;

use function ob_start;
use function ob_end_clean;

trait TaskQueueTestTrait
{
	private function startOutputBuffering()
	{
		ob_start();
	}

	private function endOutputBuffering()
	{
		ob_end_clean();
	}
}
