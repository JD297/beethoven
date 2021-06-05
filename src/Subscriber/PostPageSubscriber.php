<?php declare(strict_types=1);

namespace App\Subscriber;

use App\Page\Post\PostPage;
use App\Page\Post\PostPageLoadedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PostPageSubscriber implements EventSubscriberInterface
{
	/**
	 * @var EntityManagerInterface $entityManager
	 */
	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			PostPageLoadedEvent::class => [
				['addView', 0],
			],
		];
	}

	public function addView(PostPageLoadedEvent $event)
	{
		/** @var PostPage $page */
		$page = $event->getPage();

		$post = $page->getPost()->addView();

		$this->entityManager->persist($post);
		$this->entityManager->flush();
	}
}