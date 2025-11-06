<?php

declare(strict_types=1);

namespace App\Search;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias(ConferenceSearchInterface::class)]
final class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        #[Target('devevents-api.client')]
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        $options = [
            'query' => [],
        ];

        $name = trim($name ?? '');

        if ('' !== $name) {
            $options['query']['name'] = $name;
        }

        $response = $this->httpClient->request('GET', '/events', $options);
        dump($response->toArray());

        return [];

        return $response->toArray();
    }
}
