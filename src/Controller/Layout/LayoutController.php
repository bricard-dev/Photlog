<?php

namespace App\Controller\Layout;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LayoutController extends AbstractController
{
    public function allCategories(CategoryRepository $categoryRepository, string $class): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('layouts/partials/_all_categories.html.twig', [
            'categories' => $categories,
            'class' => $class,
        ]);
    }

    public function mostPopularPosts( PostRepository $postRepository): Response
    {
        $popularPosts = $postRepository->findBy([], ['viewCounter' => 'DESC'], 2);

        return $this->render('layouts/partials/_most_popular_posts.html.twig', [
            'popularPosts' => $popularPosts
        ]);
    }

    #[Route('/about', name: 'app_about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('layouts/about.html.twig');
    }
}
