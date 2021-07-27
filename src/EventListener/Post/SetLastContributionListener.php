<?php declare(strict_types=1);

namespace Beethoven\EventListener\Post;

use Beethoven\Entity\Comment;
use Beethoven\Entity\Post;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SetLastContributionListener
{
	public function postLoad(Post $post, LifecycleEventArgs $event): void
	{
		$lastComment = $post->getComments()->last();

		if($lastComment instanceof Comment) {
			$post->setLastContribution($lastComment);
		}
	}
}
