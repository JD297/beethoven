<?php declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Page\Forum\ForumPageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
	private ForumPageLoader $forumPageLoader;

	public function __construct(ForumPageLoader $forumPageLoader) {
		$this->forumPageLoader = $forumPageLoader;
	}

	/**
	 * @Route("/forum/{forumId}", name="frontend.forum.index.page", requirements={"forumId"="\d+"}, methods={"GET"})
	 * @param int forumId
	 * @return Response
	 */
	public function index(int $forumId): Response
	{
		$page = $this->forumPageLoader->load($forumId);

		return $this->render('page/forum/index.html.twig', [
			'page' => $page->getData()
		]);
	}
}
