<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    public ?string $firstName;
    public ?string $lastName;
    public ?string $email;
    public ?string $password;
    public ?string $role = 'contributor';
}
