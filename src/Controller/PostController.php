<?php declare(strict_types=1);

namespace App\Controller;

use App\Page\Post\PostPageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
	private PostPageLoader $postPageLoader;

	public function __construct(PostPageLoader $postPageLoader) {
		$this->postPageLoader = $postPageLoader;
	}

	/**
	 * @Route("/post/{postId}", name="frontend.post.index.page", requirements={"postId"="\d+"}, methods={"GET"})
	 * @param int $postId
	 * @return Response
	 */
	public function index(int $postId): Response
	{
		$page = $this->postPageLoader->load($postId);

		return $this->render('page/post/index.html.twig', [
			'page' => $page->getData()
		]);
	}
}
