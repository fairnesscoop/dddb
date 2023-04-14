<?php

declare(strict_types=1);

namespace App\Domain\User\Enum;

enum RoleEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_CONTRIBUTOR = 'ROLE_CONTRIBUTOR';
}
