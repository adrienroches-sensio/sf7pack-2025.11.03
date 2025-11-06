<?php

declare(strict_types=1);

namespace App\Search;

use App\Repository\ConferenceRepository;

final class DatabaseConferenceSearch
{
    public function __construct(
        private readonly ConferenceRepository $conferenceRepository,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        if (null === $name) {
            return $this->conferenceRepository->listAll();
        }

        return $this->conferenceRepository->searchByName($name);
    }
}
