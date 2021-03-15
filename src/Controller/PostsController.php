<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([], ['createdAt' => 'DESC']);

        $pagination = $paginator->paginate($posts, $request->query->getInt('page', 1), Post::POST_PER_PAGE);

        //dd($pagination->getItems());

        return $this->render('posts/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/posts/{slug}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {    
        return $this->render('posts/show.html.twig', [
            'post' => $post,
        ]);
    }
}
