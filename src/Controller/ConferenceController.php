<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Conference;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConferenceController extends AbstractController
{
    #[Route('/conference/{name}/{start}/{end}', name: 'app_conference_new')]
    public function newConference(string $name, string $start, string $end, /* ... */): Response
    {
        $conference = (new Conference())
            ->setName($name)
            ->setDescription('Some generic description')
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end))
        ;

        //...

        return new Response('Conference created');
    }
}
