<?php declare(strict_types=1);

namespace Beethoven\EventListener\Topic;

use Beethoven\Entity\Comment;
use Beethoven\Entity\Topic;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SetLastContributionListener
{
	public function postLoad(Topic $topic, LifecycleEventArgs $event): void
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
}
