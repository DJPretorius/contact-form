<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Logs\Log;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post, [
            'action' => $this->generateUrl('process_form'),
            'method' => "POST"
        ]);

        return $this->renderForm('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form,
        ]);

        
    }

    #[Route('/post', name: 'process_form')]
    public function processForm(Request $request, PostRepository $postRepository, TransportInterface $mailer)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $postRepository->add($post);

            $name = $post->getName();

            $email = (new Email())
                ->from($post->getEmail())
                ->to('contact@example.com')
                ->subject("Contact form from $name")
                ->text($post->getDescription());

            try {
                $sentMessage = $mailer->send($email);
                Log::getLogger()->debug(__METHOD__, [
                    "message" => $sentMessage->getOriginalMessage(),
                    'debug' => $sentMessage->getDebug()
                ]);
            } catch (TransportExceptionInterface $e) {
                Log::getLogger()->debug(__METHOD__, [
                    "message" => $e->getMessage()                    
                ]);
            }

            return $this->redirectToRoute('app_home');
        }
    }
}
