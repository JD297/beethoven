<?php declare(strict_types=1);

namespace App\Page\Forum;

use App\Page\PageLoadedEvent;
use Symfony\Component\HttpFoundation\Request;

class ForumPageLoadedEvent extends PageLoadedEvent
{
	protected ForumPage $page;

	public function __construct(ForumPage $page, Request $request)
	{
		$this->page = $page;
		parent::__construct($request);
	}
}