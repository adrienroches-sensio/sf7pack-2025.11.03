<?php

declare(strict_types=1);

namespace App\Search;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias(ConferenceSearchInterface::class)]
final class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,

        #[Autowire(env: 'DEVEVENTS_API_KEY')]
        private readonly string $apiKey,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        $options = [
            'headers' => [
                'apikey' => $this->apiKey,
                'accept' => 'application/json',
            ],
            'query' => []
        ];

        $name = trim($name ?? '');

        if ('' !== $name) {
            $options['query']['name'] = $name;
        }

        $response = $this->httpClient->request('GET', 'https://devevents-api.fr/events', $options);
        dump($response->toArray());

        return [];

        return $response->toArray();
    }
}
