<?php declare(strict_types=1);

namespace App\Page;

use App\Framework\Event\Event;
use Symfony\Component\HttpFoundation\Request;

abstract class PageLoadedEvent extends Event
{
	protected PageInterface $page;

	public function __construct(PageInterface $page, Request $request)
	{
		$this->page = $page;
		parent::__construct($request);
	}

	/**
	 * @return PageInterface
	 */
	public function getPage(): PageInterface
	{
		return $this->page;
	}

	/**
	 * @param PageInterface $page
	 */
	public function setPage(PageInterface $page): void
	{
		$this->page = $page;
	}
}