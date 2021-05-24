<?php declare(strict_types=1);

namespace App\Page\Forum;

use App\Page\AbstractPageLoader;
use App\Page\PageInterface;
use App\Page\PageLoaderInterface;
use App\Repository\ForumRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class ForumPageLoader extends AbstractPageLoader implements PageLoaderInterface
{
	protected ForumRepository $forumRepository;

	public function __construct(
		ForumRepository $forumRepository,
		EventDispatcherInterface $eventDispatcher
	) {
		$this->forumRepository = $forumRepository;
		parent::__construct($eventDispatcher);
	}

	public function load(Request $request): PageInterface
	{
		$criteria = new Criteria();
		$criteria->where(new Comparison('active', Comparison::EQ, true));

		$this->eventDispatcher->dispatch(
			new ForumPageCriteriaEvent($criteria, $request)
		);

		$forumCollection = $this->forumRepository->matching($criteria);

		$page = new ForumPage();
		$page->setDataCollection($forumCollection);

		$this->eventDispatcher->dispatch(
			new ForumPageLoadedEvent($page, $request)
		);

		return $page;
	}
}