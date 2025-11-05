<?php

namespace App\DataFixtures;

use App\Entity\Conference;
use App\Entity\Organization;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sensioLabs = $this->createOrganization('SensioLabs');
        $manager->persist($sensioLabs);

        for ($i = 15; $i <= 25; $i++) {
            $year = '20' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $symfonyLive = $this->createConference(
                name: "SymfonyLive {$year}",
                start: new DateTimeImmutable("{$year}-03-22"),
                organizations: [$sensioLabs],
                description: "Annual conference in Paris ({$year}).",
            );
            $manager->persist($symfonyLive);
        }

        $manager->flush();
    }

    private function createOrganization(
        string $name,
    ): Organization {
        $organization = new Organization();
        $organization->setName($name);
        $organization->setPresentation("Random presentation for {$name}.");
        $organization->setCreatedAt(new DateTimeImmutable('2025-11-05'));

        return $organization;
    }

    private function createConference(
        string $name,
        DateTimeImmutable $start,
        array $organizations = [],
        bool $accessible = true,
        string|null $description = null,
        string|null $prerequisites = null,
    ): Conference
    {
        $conference = new Conference();
        $conference->setName($name);
        $conference->setAccessible($accessible);
        $conference->setDescription($description ?? "Random description for {$name}.");
        $conference->setStartAt($start);
        $conference->setEndAt($start->modify('+2 days'));
        $conference->setPrerequisites($prerequisites);

        foreach ($organizations as $organization) {
            $conference->addOrganization($organization);
        }

        return $conference;
    }
}
