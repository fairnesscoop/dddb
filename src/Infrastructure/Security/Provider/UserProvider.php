<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\Provider;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use App\Infrastructure\Security\SymfonyUser;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findOneByEmail($identifier);

        if (!$user instanceof User) {
            throw new UserNotFoundException(\sprintf('Unable to find the user %s', $identifier));
        }

        return $this->createFromDomainUser($user);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if ($user instanceof SymfonyUser) {
            return $this->createFromDomainUser($this->userRepository->findByUuid($user->getUuid()));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return SymfonyUser::class === $class;
    }

    private function createFromDomainUser(User $user): SymfonyUser
    {
        return new SymfonyUser(
            $user->getUuid(),
            $user->getEmail(),
            $user->getFullName(),
            $user->getPassword(),
            [$user->getRole()->value],
        );
    }
}
