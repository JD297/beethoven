<?php declare(strict_types=1);

namespace Beethoven\Page\Post;

use Beethoven\Entity\Post;
use Beethoven\Repository\PostRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostPageLoader
{
	protected PostRepository $postRepository;
	protected EventDispatcherInterface $eventDispatcher;

	public function __construct(
		PostRepository $postRepository,
		EventDispatcherInterface $eventDispatcher
	) {
		$this->postRepository = $postRepository;
		$this->eventDispatcher = $eventDispatcher;
	}

	public function load(int $postId): PostPage
	{
		$criteria = new Criteria();
		$criteria->where(new CompositeExpression(CompositeExpression::TYPE_AND, [
			new Comparison('id', Comparison::EQ, $postId),
			new Comparison('active', Comparison::EQ, true),
		]));

		$this->eventDispatcher->dispatch(
			new PostCriteriaLoadedEvent($criteria)
		);

		/** @var Post|bool $topic */
		$topic = $this->postRepository->matching($criteria)->first();

		if (!$topic instanceof Post) {
			throw new NotFoundHttpException();
		}

		$page = new PostPage($topic);

		$this->eventDispatcher->dispatch(
			new PostPageLoadedEvent($page)
		);

		return $page;
	}
}
