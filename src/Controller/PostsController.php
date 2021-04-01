<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentFormType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Gedmo\Mapping\Annotation\Slug;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy(['isEnable' => true], ['createdAt' => 'DESC']);

        $pagination = $paginator->paginate($posts, $request->query->getInt('page', 1), Post::POST_PER_PAGE);

        return $this->render('posts/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/posts/{slug}', name: 'app_post_show', methods: ['GET', 'POST'])]
    public function show(Request $request, PaginatorInterface $paginator, Post $post, EntityManagerInterface $em): Response
    {   
        if (!$post->getIsEnable()) {
            throw new NotFoundHttpException('Failed to access to this post because it is not enable');
        }

        $count = $post->getViewCounter();
        $post->setViewCounter($count + 1);

        $em->flush();

        $comments = $post->getComments();
        $pagination = $paginator->paginate($comments, $request->query->getInt('page', 1), Comment::COMMENT_PER_PAGE);

        $comment = new Comment;
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);
            $this->em->persist($comment);
            $this->em->flush();

            $this->addFlash('success', 'Your comment has been added!');
            return $this->redirectToRoute('app_post_show', ['slug' => $post->getSlug()]);
        }

        return $this->render('posts/show.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
}
