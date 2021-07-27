<?php declare(strict_types=1);

namespace App\EventListener\Post;

use App\Entity\Post;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class FilterActiveCommentsListener
{
	public function postLoad(Post $post, LifecycleEventArgs $event): void
	{
		$comments = $post->getComments()->filter(function($comment) {
			return $comment->getActive();
		});

		$post->setComments($comments);
	}
}
