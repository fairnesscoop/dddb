<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Application\QueryInterface;

final class ListUsersQuery implements QueryInterface
{
    public function __construct(
        public readonly int $page,
        public readonly int $pageSize,
    ) {
    }
}
