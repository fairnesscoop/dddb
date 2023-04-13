<?php

declare(strict_types=1);

namespace App\Application\User\Command;

// use App\Domain\User\User;

class CreateUserCommandHandler
{
    public function __construct()
    {
    }

    // dont forget to change invoke return type to "User"
    public function __invoke(CreateUserCommand $createUserCommand): void
    {
        dump($createUserCommand);
    }
}
