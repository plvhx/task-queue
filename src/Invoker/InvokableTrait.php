<?php

declare(strict_types=1);

namespace TaskQueue\Invoker;

/**
 * @author Paulus Gandung Prakosa <gandung@lists.infradead.org>
 */
trait InvokableTrait
{
	/**
	 * @var mixed
	 */
	private $invokable;

	/**
	 * {@inheritdoc}
	 */
	public function getInvokable()
	{
		return $this->invokable;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setInvokable($invokable)
	{
		$this->invokable = $invokable;
	}
}
