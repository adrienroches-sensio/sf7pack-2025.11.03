<?php

declare(strict_types=1);

namespace App\Search;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        #[Autowire(env: 'DEVEVENTS_API_KEY')]
        private readonly string $apiKey,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
    }
}
