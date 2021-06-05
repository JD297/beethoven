<?php declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Comment;
use App\Entity\Topic;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TopicListener
{
	public function postLoad(Topic $topic, LifecycleEventArgs $event): void
	{
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
