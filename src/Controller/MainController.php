<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'app_index',
        methods: ['GET']
    )]
    public function index(): Response
    {
        return new Response('Hello World!');
    }
}
