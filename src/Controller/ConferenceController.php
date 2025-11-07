<?php

declare(strict_types=1);

namespace App\Controller;

use App\Conference\ConferenceSubmittedEvent;
use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use App\Search\ConferenceSearchInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ConferenceController extends AbstractController
{
    #[Route(
        path: '/conferences/new',
        name: 'app_conference_new',
        methods: ['GET', 'POST']
    )]
    #[IsGranted(new Expression('is_granted("ROLE_WEBSITE") or is_granted("ROLE_ORGANIZER")'))]
    public function newConference(Request $request, EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher): Response
    {
        $conference = new Conference();

        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conference->setCreatedBy($this->getUser());

            $event = new ConferenceSubmittedEvent($conference);
            $eventDispatcher->dispatch($event);

            if (!$event->isRejected()) {
                $entityManager->persist($conference);
                $entityManager->flush();

                return $this->redirectToRoute('app_conference_list');
            }

            foreach ($event->getRejectReasons() as $reason) {
                $form->addError(new FormError($reason));
            }
        }

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
        $conferences = $conferenceRepository->listAll();

        return $this->render('conferences/list.html.twig', [
            'conferences' => $conferences,
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

    #[Route(
        path: '/conference/search',
        name: 'app_conference_search',
        methods: ['GET'],
    )]
    #[Template('conferences/search.html.twig')]
    public function search(Request $request, ConferenceSearchInterface $conferenceSearch): array
    {
        $name = $request->query->getString('name', '');

        $conferences = $conferenceSearch->searchByName($name);

        return [
            'conferences' => $conferences,
            'nameQuery' => $name,
        ];
    }
}
