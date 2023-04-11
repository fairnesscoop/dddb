<?php

declare(strict_types=1);

namespace App\Domain\User\Enum;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case CONTRIBUTOR = 'contributor';
}
