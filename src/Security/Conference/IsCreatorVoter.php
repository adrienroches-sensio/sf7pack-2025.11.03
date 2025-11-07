<?php

declare(strict_types=1);

namespace App\Security\Conference;

use App\Entity\Conference;
use App\Entity\User;
use App\Security\ConferencePermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class IsCreatorVoter implements VoterInterface
{
    public function vote(TokenInterface $token, mixed $subject, array $attributes, ?Vote $vote = null): int
    {
        if (! $subject instanceof Conference) {
            return self::ACCESS_ABSTAIN;
        }

        if (! $token->getUser() instanceof User) {
            return self::ACCESS_ABSTAIN;
        }

        [$attribute] = $attributes;

        if ($attribute !== ConferencePermission::EDIT) {
            return self::ACCESS_ABSTAIN;
        }

        if ($subject->getCreatedBy()->getUserIdentifier() === $token->getUser()->getUserIdentifier()) {
            return self::ACCESS_GRANTED;
        }

        $vote?->addReason('User is not the creator.');

        return self::ACCESS_ABSTAIN;
    }
}
