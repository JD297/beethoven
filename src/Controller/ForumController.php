<?php declare(strict_types=1);

namespace App\Controller;

use App\Page\Forum\ForumPageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
	private ForumPageLoader $dashboardPageLoader;

	public function __construct(ForumPageLoader $dashboardPageLoader) {
		$this->dashboardPageLoader = $dashboardPageLoader;
	}

	/**
	 * @Route("/", name="frontend.forum.index.page")
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request): Response
	{
		$page = $this->dashboardPageLoader->load($request);

		return $this->render('page/forum/index.html.twig', ['page' => $page]);
	}
}
