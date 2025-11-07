<?php

declare(strict_types=1);

namespace App\Security\Conference;

use App\Entity\Conference;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use function str_starts_with;

final class IsWebsiteStaffVoter implements VoterInterface
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes, ?Vote $vote = null): int
    {
        [$attribute] = $attributes;

        if (! str_starts_with($attribute, 'conference/')) {
            return self::ACCESS_ABSTAIN;
        }

        if (! $subject instanceof Conference) {
            return self::ACCESS_ABSTAIN;
        }

        $isRoleWebsite = $this->authorizationChecker->isGranted('ROLE_WEBSITE');

        if (false === $isRoleWebsite) {
            $vote?->addReason('User is not a website staff.');

            return self::ACCESS_ABSTAIN;
        }

        return self::ACCESS_GRANTED;
    }
}
