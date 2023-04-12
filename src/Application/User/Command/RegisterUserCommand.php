<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\CommandInterface;
use App\Domain\User\Enum\RoleEnum;

final class RegisterUserCommand implements CommandInterface
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password,
        private ?string $role = RoleEnum::ADMIN->value,
    ) {
    }
}
