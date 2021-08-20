<?php declare(strict_types=1);

namespace Beethoven\Page\Forum;

use Beethoven\Entity\Forum;
use Beethoven\Repository\ForumRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ForumPageLoader
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

	public function load(int $forumId): ForumPage
	{
		$criteria = new Criteria();
		$criteria->where(new CompositeExpression(CompositeExpression::TYPE_AND, [
			new Comparison('id', Comparison::EQ, $forumId),
			new Comparison('active', Comparison::EQ, true),
		]));

		$this->eventDispatcher->dispatch(
			new ForumCriteriaLoadedEvent($criteria)
		);

		/** @var Forum|bool $forum */
		$forum = $this->forumRepository->matching($criteria)->first();

		if (!$forum instanceof Forum) {
			throw new NotFoundHttpException();
		}

		$page = new ForumPage($forum);

		$this->eventDispatcher->dispatch(
			new ForumPageLoadedEvent($page)
		);

		return $page;
	}
}
