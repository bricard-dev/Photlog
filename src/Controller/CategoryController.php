<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories/{slug}', name: 'app_category_show', methods: ['GET'])]
    public function show(Request $request, PaginatorInterface $paginator, Category $category): Response
    {
        $posts = array_filter($category->getPosts()->toArray(), function($e) {
            return $e->getIsEnable();
        });

        $pagination = $paginator->paginate(array_reverse($posts), $request->query->getInt('page', 1), Post::POST_PER_PAGE);

        return $this->render('categories/show.html.twig', [
            'category' => $category,
            'pagination' => $pagination,
        ]);
    }
}
