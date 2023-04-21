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

        $result = $this->userRepository->findUsers(
            page: $page,
            pageSize: $pageSize,
        );

        return new Pagination(
            items: $result['items'],
            totalItems: $result['totalItems'],
            page: $page,
            pageSize: $pageSize,
        );
    }
}
