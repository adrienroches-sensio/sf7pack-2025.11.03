<?php

declare(strict_types=1);

namespace App\Conference;

use DateTimeImmutable;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use function strtolower;

final class ConferenceSubscriber
{
    #[AsEventListener]
    public function rejectConferenceIfTooFarInFuture(ConferenceSubmittedEvent $event): void
    {
        if ($event->conference->getStartAt() < new DateTimeImmutable('+2 years')) {
            return;
        }

        $event->reject('The conference is too far in the future (maximum 2 years ahead).');
    }

    #[AsEventListener]
    public function rejectConferenceIfRelatedToDoctrine(ConferenceSubmittedEvent $event): void
    {
        if (!str_contains(strtolower($event->conference->getName()), 'doctrine')) {
            return;
        }

        $event->reject('We don\'t allow conferences related to Doctrine anymore.');
    }
}
