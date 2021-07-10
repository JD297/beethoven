<?php declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class PostListener
{
	public function postLoad(Post $post, LifecycleEventArgs $event): void
	{
		$lastComment = $post->getComments()->filter(function($comment) {
			return $comment->getActive();
		})->last();

		if($lastComment instanceof Comment) {
			$post->setLastContribution($lastComment);
		}
	}
}
