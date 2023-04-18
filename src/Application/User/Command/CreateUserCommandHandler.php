<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\IdFactoryInterface;
use App\Application\PasswordHasherInterface;
use App\Domain\User\Exception\UserAlreadyRegisteredException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\IsUserAlreadyRegistred;
use App\Domain\User\User;

class CreateUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private IsUserAlreadyRegistred $isUserAlreadyRegistred,
        private IdFactoryInterface $idFactory,
        private PasswordHasherInterface $passwordHasher,
    ) {
    }

    // dont forget to change invoke return type to "User"
    public function __invoke(CreateUserCommand $createUserCommand): User
    {
        $email = trim(strtolower($createUserCommand->email));

        if ($this->isUserAlreadyRegistred->isSatisfiedBy($email)) {
            throw new UserAlreadyRegisteredException();
        }

        $uuid = $this->idFactory->make();
        $password = $this->passwordHasher->hash($createUserCommand->password);

        return $this->userRepository->add(
            new User(
                $uuid,
                $createUserCommand->firstName,
                $createUserCommand->lastName,
                $email,
                $password,
                $createUserCommand->role,
            ),
        );
    }
}
