<?php declare(strict_types=1);

namespace Beethoven\EventListener\Topic;

use Beethoven\Entity\Topic;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SetLastContributionCountListener
{
	public function postLoad(Topic $topic, LifecycleEventArgs $event): void
	{
		foreach ($topic->getPosts() as $post) {
			$topic->setContributionCount(
				$topic->getContributionCount() + $post->getComments()->count()
			);
		}
	}
}
