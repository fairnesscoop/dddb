<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Domain\Pagination;
use App\Domain\User\Repository\UserRepositoryInterface;

final class ListUsersQueryHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(ListUsersQuery $listUsersQuery): Pagination
    {
        $page = $listUsersQuery->page;
        $pageSize = $listUsersQuery->pageSize;

        $users = $this->userRepository->findUsers(
            page: $page,
            pageSize: $pageSize,
        );

        $totalUsers = $this->userRepository->countUsers();

        return new Pagination(
            items: $users,
            totalItems: $totalUsers,
            page: $page,
            pageSize: $pageSize,
        );
    }
}
