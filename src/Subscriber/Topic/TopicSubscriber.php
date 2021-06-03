<?php declare(strict_types=1);

namespace App\Subscriber\Topic;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Topic;
use App\Event\Topic\TopicLoadedEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TopicSubscriber implements EventSubscriberInterface
{
	public static function getSubscribedEvents(): array
	{
		return [
			TopicLoadedEvent::class => [
				['lastContribution', 0],
			],
		];
	}

	public function lastContribution(TopicLoadedEvent $event)
	{
		/** @var Topic $topic */
		$topic = $event->getEntity();

		$posts = $topic->getPosts();

		if($posts->count() === 0) {
			return;
		}

		$iteratorPosts = $topic->getPosts()->getIterator();

		// sort by last contribution asc
		$iteratorPosts->uasort(function ($a, $b) {
			return $a->getLastcontribution() <=> $b->getLastcontribution();
		});

		$postsSorted = new ArrayCollection(iterator_to_array($iteratorPosts));

		$lastContribution = $postsSorted->last()->getLastcontribution();

		if($lastContribution instanceof Comment) {
			$topic->setLastContribution($lastContribution);
		}
	}
}