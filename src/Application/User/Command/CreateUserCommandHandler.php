<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\IdFactoryInterface;
use App\Application\PasswordHasherInterface;
use App\Domain\User\Enum\RoleEnum;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;

class CreateUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private IdFactoryInterface $idFactory,
        private readonly PasswordHasherInterface $passwordHasher,
    ) {
    }

    // dont forget to change invoke return type to "User"
    public function __invoke(CreateUserCommand $createUserCommand): User
    {
        $email = trim(strtolower($createUserCommand->email));

        // check if email already exists

        $uuid = $this->idFactory->make();
        $password = $this->passwordHasher->hash($createUserCommand->password);

        dump($email);
        dump($uuid);
        dump($password);

        return new User(
            'uuid1',
            'benoit',
            'paquier',
            'email@mail.mail',
            'temptemp',
            RoleEnum::ADMIN,
        );
    }
}
