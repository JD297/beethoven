<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
	/**
	 * @Route("/", name="frontend.page.dashboard")
	 */
	public function index(): Response
	{
		return $this->render('page/dashboard.html.twig');
	}
}
