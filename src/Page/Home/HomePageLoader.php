<?php declare(strict_types=1);

namespace Beethoven\Page\Home;

use Beethoven\Event\Post\PostLoadedEvent;
use Beethoven\Event\Topic\TopicLoadedEvent;
use Beethoven\Repository\ForumRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\ORM\LazyCriteriaCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class HomePageLoader
{
	protected ForumRepository $forumRepository;
	protected EventDispatcherInterface $eventDispatcher;

	public function __construct(
		ForumRepository $forumRepository,
		EventDispatcherInterface $eventDispatcher
	) {
		$this->forumRepository = $forumRepository;
		$this->eventDispatcher = $eventDispatcher;
	}

	public function load(): HomePage
	{
		$criteria = new Criteria();
		$criteria->where(new CompositeExpression(CompositeExpression::TYPE_AND, [
			new Comparison('active', Comparison::EQ, true),
		]));

		$this->eventDispatcher->dispatch(
			new HomeCriteriaLoadedEvent($criteria)
		);

		$forumCollection = $this->forumRepository->matching($criteria);

		$page = new HomePage($forumCollection);

		$this->eventDispatcher->dispatch(
			new HomePageLoadedEvent($page)
		);

		return $page;
	}
}