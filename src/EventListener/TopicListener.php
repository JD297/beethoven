<?php declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Comment;
use App\Entity\Topic;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TopicListener
{
	public function postLoad(Topic $topic, LifecycleEventArgs $event): void
	{
		$this->filterActivePosts($topic);

		$this->setLastContribution($topic);
	}

	private function setLastContribution(Topic $topic): void
	{
		$iteratorPosts = $topic->getPosts()->getIterator();

		if($iteratorPosts->count() === 0) {
			return;
		}

		// sort by last contribution desc
		$iteratorPosts->uasort(function ($a, $b) {
			return $b->getLastcontribution() <=> $a->getLastcontribution();
		});

		$lastContribution = $iteratorPosts->current()->getLastcontribution();

		if($lastContribution instanceof Comment) {
			$topic->setLastContribution($lastContribution);
		}
	}

	private function filterActivePosts(Topic $topic): void
	{
		$posts = $topic->getPosts()->filter(function($post) {
			return $post->getActive();
		});

		$topic->setPosts($posts);
	}
}
