<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Logs\Log;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        Log::getLogger()->debug("Home", [
            'data' => $form->getData()
        ]);

        return $this->renderForm('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form,
        ]);

        
    }

    #[Route('/post', name: 'process_form')]
    public function processForm(Request $request, PostRepository $postRepository)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $postRepository->add($post);

            return $this->redirectToRoute('app_home');
        }
    }
}
