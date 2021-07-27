<?php declare(strict_types=1);

namespace Beethoven\Controller\Admin;

use Beethoven\Entity\Comment;
use Beethoven\Entity\Forum;
use Beethoven\Entity\Post;
use Beethoven\Entity\Topic;
use Beethoven\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
	    return $this->render('@Frontend/admin/dashboard/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Beethoven');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Forums', 'fas fa-globe', Forum::class);
        yield MenuItem::linkToCrud('Topics', 'fas fa-folder-open', Topic::class);
        yield MenuItem::linkToCrud('Posts', 'fas fa-envelope-open', Post::class);
        yield MenuItem::linkToCrud('Comments', 'fas fa-comments', Comment::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
    }
}
