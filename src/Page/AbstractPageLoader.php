<?php declare(strict_types=1);

namespace App\Page;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AbstractPageLoader
{
	protected EventDispatcherInterface $eventDispatcher;

	public function __construct(EventDispatcherInterface $eventDispatcher)
	{
		$this->eventDispatcher = $eventDispatcher;
	}
}