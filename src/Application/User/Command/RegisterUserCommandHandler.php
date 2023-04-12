<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\User\User;

class RegisterUserCommandHandler
{
    public function __construct()
    {
    }

    // dont forget to change invoke return type to "User"
    public function __invoke(RegisterUserCommand $registerUserCommand): void
    {
        dump($registerUserCommand);
    }
}
