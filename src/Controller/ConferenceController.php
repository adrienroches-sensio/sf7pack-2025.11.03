<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ConferenceController extends AbstractController
{
    #[Route(
        path: '/conferences/new',
        name: 'app_conference_new',
    )]
    public function newConference(): Response
    {
        $conference = new Conference();

        $form = $this->createForm(ConferenceType::class, $conference);

        return $this->render('conferences/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        path: '/conferences',
        name: 'app_conference_list',
        methods: ['GET'],
    )]
    public function list(ConferenceRepository $conferenceRepository): Response
    {
        return $this->render('conferences/list.html.twig', [
            'conferences' => $conferenceRepository->listAll(),
        ]);
    }

    #[Route(
        path: '/conferences/{id}',
        name: 'app_conference_show',
        requirements: [
            'id' => Requirement::DIGITS,
        ],
        methods: ['GET'],
    )]
    public function show(Conference $conference): Response
    {
        return $this->render('conferences/show.html.twig', [
            'conference' => $conference,
        ]);
    }
}
