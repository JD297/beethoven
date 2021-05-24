<?php declare(strict_types=1);

namespace App\Controller;

use App\Page\Dashboard\DashboardPage;
use App\Page\Dashboard\DashboardPageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
	private DashboardPageLoader $dashboardPageLoader;

	public function __construct(DashboardPageLoader $dashboardPageLoader) {
		$this->dashboardPageLoader = $dashboardPageLoader;
	}

	/**
	 * @Route("/", name="frontend.page.dashboard")
	 */
	public function index(Request $request): Response
	{
		/** @var DashboardPage $page */
		$page = $this->dashboardPageLoader->load($request);

		return $this->render('page/dashboard.html.twig', ['page' => $page]);
	}
}
