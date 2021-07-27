<?php declare(strict_types=1);

namespace App\EventListener\Topic;

use App\Entity\Topic;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class FilterActivePostsListener
{
	public function postLoad(Topic $topic, LifecycleEventArgs $event): void
	{
		$posts = $topic->getPosts()->filter(function($post) {
			return $post->getActive();
		});

		$topic->setPosts($posts);
	}
}
