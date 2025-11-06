<?php

declare(strict_types=1);

namespace App\Search;

use App\Repository\ConferenceRepository;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

//#[AsAlias(ConferenceSearchInterface::class)]
final class DatabaseConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        private readonly ConferenceRepository $conferenceRepository,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        $name = trim($name ?? '');

        if ('' === $name) {
            return $this->conferenceRepository->listAll();
        }

        return $this->conferenceRepository->searchByName($name);
    }
}
