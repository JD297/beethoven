<?php declare(strict_types=1);

namespace App\Subscriber\Post;

use App\Entity\Comment;
use App\Entity\Post;
use App\Event\Post\PostLoadedEvent;
use App\Page\Post\PostPage;
use App\Page\Post\PostPageLoadedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PostSubscriber implements EventSubscriberInterface
{
	/**
	 * @var EntityManagerInterface $entityManager
	 */
	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public static function getSubscribedEvents()
	{
		return [
			PostPageLoadedEvent::class => [
				['addView', 0],
			],
			PostLoadedEvent::class => [
				['lastContribution', 0],
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

	public function lastContribution(PostLoadedEvent $event)
	{
		/** @var Post $post */
		$post = $event->getEntity();

		$lastComment = $post->getComments()->last();

		if($lastComment instanceof Comment) {
			$post->setLastContribution($lastComment);
		}
	}
}