<?php declare(strict_types=1);

namespace Beethoven\Page\Topic;

use Beethoven\Entity\Topic;
use Beethoven\Event\Post\PostLoadedEvent;
use Beethoven\Repository\TopicRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TopicPageLoader
{
	protected TopicRepository $topicRepository;
	protected EventDispatcherInterface $eventDispatcher;

	public function __construct(
		TopicRepository $topicRepository,
		EventDispatcherInterface $eventDispatcher
	) {
		$this->topicRepository = $topicRepository;
		$this->eventDispatcher = $eventDispatcher;
	}

	public function load(int $topicId): TopicPage
	{
		$criteria = new Criteria();
		$criteria->where(new CompositeExpression(CompositeExpression::TYPE_AND, [
			new Comparison('id', Comparison::EQ, $topicId),
			new Comparison('active', Comparison::EQ, true),
		]));

		$this->eventDispatcher->dispatch(
			new TopicCriteriaLoadedEvent($criteria)
		);

		/** @var Topic|bool $topic */
		$topic = $this->topicRepository->matching($criteria)->first();

		if(!$topic instanceof Topic) {
			throw new NotFoundHttpException();
		}

		$page = new TopicPage($topic);

		$this->eventDispatcher->dispatch(
			new TopicPageLoadedEvent($page)
		);

		return $page;
	}
}