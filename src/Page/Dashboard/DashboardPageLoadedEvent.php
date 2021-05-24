<?php declare(strict_types=1);

namespace App\Page\Dashboard;

use App\Page\PageLoadedEvent;
use Symfony\Component\HttpFoundation\Request;

class DashboardPageLoadedEvent extends PageLoadedEvent
{
	protected DashboardPage $page;

	public function __construct(DashboardPage $page, Request $request)
	{
		$this->page = $page;
		parent::__construct($request);
	}
}