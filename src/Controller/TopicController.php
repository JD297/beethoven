<?php declare(strict_types=1);

namespace App\Controller;

use App\Page\Topic\TopicPageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
	private TopicPageLoader $topicPageLoader;

	public function __construct(TopicPageLoader $topicPageLoader) {
		$this->topicPageLoader = $topicPageLoader;
	}

	/**
	 * @Route("/topic/{id}", name="frontend.topic.index.page")
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request): Response
	{
		$page = $this->topicPageLoader->load($request);

		return $this->render('page/topic/index.html.twig', ['page' => $page]);
	}
}
