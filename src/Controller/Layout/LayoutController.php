<?php

namespace App\Controller\Layout;

use App\Entity\Category;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
        $popularPosts = $postRepository->findBy(['isEnable' => 'true'], ['viewCounter' => 'DESC'], 2);

        return $this->render('layouts/partials/_most_popular_posts.html.twig', [
            'popularPosts' => $popularPosts
        ]);
    }

    #[Route('/about', name: 'app_about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('layouts/about.html.twig');
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact;

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email)
                ->from('noreply@bastienricard.fr')
                ->to('contact@bastienricard.fr')
                ->replyTo($contact->getEmail())
                ->subject('Contact from Photlog : ' . $contact->getFirstName() . ' ' . $contact->getLastName())
                ->text($contact->getMessage()); 

            $mailer->send($email);

            $this->addFlash('success', 'Your message has been sent!');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('layouts/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
