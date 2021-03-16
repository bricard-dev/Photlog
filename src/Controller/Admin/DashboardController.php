<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        // return parent::index();

        // redirect to some CRUD controller
        // $routeBuilder = $this->get(AdminUrlGenerator::class);

        // return $this->redirect($routeBuilder->setController(PostCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)

        $postCrudUrl = $this->adminUrlGenerator
            ->setController(PostCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl()
        ;

        $categoryCrudUrl = $this->adminUrlGenerator
            ->setController(CategoryCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl()
        ;

        return $this->render('bundles/EasyAdminBundle/dashboard.html.twig', [
            'postCrudUrl' => $postCrudUrl,
            'categoryCrudUrl' => $categoryCrudUrl,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Photlog');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToRoute('Website', 'fas fa-globe-europe', 'app_home'),

            MenuItem::section('Blog'),
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class),
            MenuItem::linkToCrud('Posts', 'far fa-newspaper', Post::class),

            //MenuItem::section('Users'),
            //MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),
            //MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
        ];
    }
}
