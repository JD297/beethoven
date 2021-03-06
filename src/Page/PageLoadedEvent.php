<?php declare(strict_types=1);

namespace Beethoven\Page;

use Beethoven\Framework\Event\Event;

abstract class PageLoadedEvent extends Event
{
	protected Page $page;

	public function __construct(Page $page)
	{
		$this->page = $page;
	}

	public function getPage(): Page
	{
		return $this->page;
	}

	/**
	 * @return PageLoadedEvent
	 */
	public function setPage(Page $page): self
	{
		$this->page = $page;

		return $this;
	}
}
