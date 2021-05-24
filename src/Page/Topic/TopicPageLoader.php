<?php declare(strict_types=1);

namespace App\Page\Topic;

use App\Page\AbstractPageLoader;
use App\Page\PageInterface;
use App\Page\PageLoaderInterface;
use App\Repository\TopicRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TopicPageLoader extends AbstractPageLoader implements PageLoaderInterface
{
	protected TopicRepository $topicRepository;

	public function __construct(
		TopicRepository $topicRepository,
		EventDispatcherInterface $eventDispatcher
	) {
		$this->topicRepository = $topicRepository;
		parent::__construct($eventDispatcher);
	}

	public function load(Request $request): PageInterface
	{
		$topicId = $request->get('id');

		$criteria = new Criteria();
		$criteria
			->where(new Comparison('active', Comparison::EQ, true))
			->andWhere(new Comparison('id', Comparison::EQ, $topicId))
		;

		$this->eventDispatcher->dispatch(
			new TopicPageCriteriaEvent($criteria, $request)
		);

		$topicCollection = $this->topicRepository->matching($criteria);

		$page = new TopicPage();
		$page->setDataCollection($topicCollection);

		$this->eventDispatcher->dispatch(
			new TopicPageLoadedEvent($page, $request)
		);

		if($topicCollection->count() === 0) {
			throw new NotFoundHttpException('Topic was not found!');
		}

		return $page;
	}
}