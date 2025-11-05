<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class UserFixtures extends Fixture
{
    private const USERS = [
        [
            'username' => 'admin',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ],
    ];

    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userDetails) {
            [
                'username' => $username,
                'password' => $password,
                'roles' => $roles,
            ] = $userDetails;

            $user = (new User())
                ->setUsername($username)
                ->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash($password))
                ->setRoles($roles)
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
