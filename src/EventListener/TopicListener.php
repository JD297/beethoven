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

		$this->setContributionCount($topic);
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

	private function setContributionCount(Topic $topic): void
	{
		foreach($topic->getPosts() as $post) {
			$topic->setContributionCount(
				$topic->getContributionCount() + $post->getComments()->count()
			);
		}
	}
}
