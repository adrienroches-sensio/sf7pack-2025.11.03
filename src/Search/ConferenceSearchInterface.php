<?php

declare(strict_types=1);

namespace App\Search;

use App\Entity\Conference;

interface ConferenceSearchInterface
{
    /**
     * @return list<Conference>
     */
    public function searchByName(string|null $name = null): array;
}
