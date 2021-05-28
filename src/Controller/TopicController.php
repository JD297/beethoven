<?php declare(strict_types=1);

namespace App\Controller;

use App\Page\Topic\TopicPageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
	private TopicPageLoader $topicPageLoader;

	public function __construct(TopicPageLoader $topicPageLoader) {
		$this->topicPageLoader = $topicPageLoader;
	}

	/**
	 * @Route("/topic/{topicId}", name="frontend.topic.index.page", requirements={"topicId"="\d+"}, methods={"GET"})
	 * @param int $topicId
	 * @return Response
	 */
	public function index(int $topicId): Response
	{
		$page = $this->topicPageLoader->load($topicId);

		return $this->render('page/topic/index.html.twig', [
			'page' => $page->getData()
		]);
	}
}
