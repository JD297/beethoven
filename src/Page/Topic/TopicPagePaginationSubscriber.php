<?php declare(strict_types=1);

namespace Beethoven\Page\Topic;

use Beethoven\Service\Pagination\PaginationService;
use Beethoven\Service\Pagination\PaginationServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TopicPagePaginationSubscriber implements EventSubscriberInterface
{
	private PaginationService $paginationService;

	public function __construct(PaginationServiceInterface $paginationService)
	{
		$this->paginationService = $paginationService;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			TopicPageLoadedEvent::class => [
				['paginate', 1024],
			],
		];
	}

	public function paginate(TopicPageLoadedEvent $event)
	{
		/** @var TopicPage $page */
		$page = $event->getPage();

		$page->getTopic()->setPosts(
			$this->paginationService->paginate($page, $page->getTopic()->getPosts())
		);
	}
}
