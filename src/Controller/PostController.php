<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PostController extends AbstractController
{
    #[Route('/posts', name: 'get_posts', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $serializer = $this->container->get('serializer');
        $posts = $postRepository->findAll();

        $toReturn = $serializer->serialize($posts, 'json');

        return new Response($toReturn);
    }
}
