<?php declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class PostListener
{
	public function postLoad(Post $post, LifecycleEventArgs $event): void
	{
		$this->filterActiveComments($post);

		$this->setLastContribution($post);
	}

	private function filterActiveComments(Post $post): void
	{
		$comments = $post->getComments()->filter(function($comment) {
			return $comment->getActive();
		});

		$post->setComments($comments);
	}

	private function setLastContribution(Post $post): void
	{
		$lastComment = $post->getComments()->last();

		if($lastComment instanceof Comment) {
			$post->setLastContribution($lastComment);
		}
	}
}
