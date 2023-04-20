<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Domain\User\Repository\UserRepositoryInterface;

final class ListUsersQueryHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(ListUsersQuery $listUsersQuery)
    {
        $users = $this->userRepository->findUsers(
            page: $listUsersQuery->page,
            pageSize: $listUsersQuery->pageSize,
        );

        return $users;
    }
}
