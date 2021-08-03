<?php declare(strict_types=1);

namespace Beethoven\Page\Post;

use Beethoven\Service\Pagination\PaginationService;
use Beethoven\Service\Pagination\PaginationServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PostPagePaginationSubscriber implements EventSubscriberInterface
{
	private PaginationService $paginationService;

	public function __construct(PaginationServiceInterface $paginationService)
	{
		$this->paginationService = $paginationService;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			PostPageLoadedEvent::class => [
				['paginate', 1024],
			],
		];
	}

	public function paginate(PostPageLoadedEvent $event)
	{
		/** @var PostPage $page */
		$page = $event->getPage();

		$page->getPost()->setComments(
			$this->paginationService->paginate($page, $page->getPost()->getComments())
		);
	}
}