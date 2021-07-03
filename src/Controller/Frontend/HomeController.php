<?php declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Page\Home\HomePageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	private HomePageLoader $homePageLoader;

	public function __construct(HomePageLoader $homePageLoader) {
		$this->homePageLoader = $homePageLoader;
	}

	/**
	 * @Route("/", name="frontend.home.index.page", methods={"GET"})
	 * @return Response
	 */
	public function index(): Response
	{
		$page = $this->homePageLoader->load();

		return $this->render('page/home/index.html.twig', [
			'page' => $page->getData()
		]);
	}
}
