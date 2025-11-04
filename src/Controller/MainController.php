<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'app_main_index',
        methods: ['GET']
    )]
    public function index(Request $request): Response
    {
        $name = $request->query->get('name', 'World');

        return new Response("Hello {$name}!");
    }

    #[Route(path: '/contact', name: 'app_main_contact', methods: ['GET'])]
    public function contact(): Response
    {
        return new Response('Contact');
    }
}
