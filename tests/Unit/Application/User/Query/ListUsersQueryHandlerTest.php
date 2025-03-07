<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\User\Query;

use App\Application\User\Query\ListUsersQuery;
use App\Application\User\Query\ListUsersQueryHandler;
use App\Domain\Pagination;
use App\Domain\User\Repository\UserRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ListUsersQueryHandlerTest extends TestCase
{
    private MockObject&UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
    }

    public function testList(): void
    {
        $users = [
            [
                "uuid" => "abcde",
                "firstName" => "Benoit",
                "lastName" => "Paquier",
                "email" => "benoit@email.org",
                "role" => "ROLE_ADMIN"
            ],
            [
                "uuid" => "abcde",
                "firstName" => "Gregory",
                "lastName" => "Pelletier",
                "email" => "gregory@email.org",
                "role" => "ROLE_ADMIN"
            ],
            [
                "uuid" => "abcde",
                "firstName" => "Mathieu",
                "lastName" => "Marchois",
                "email" => "benoit@email.org",
                "role" => "ROLE_ADMIN"
            ],
        ];

        $pagination = new Pagination(
            items: $users,
            totalItems: count($users),
            page: 1,
            pageSize: 20
        );


        $this->userRepository
            ->expects(self::once())
            ->method('findUsers')
            ->willReturn([
                'items' => $users,
                'totalItems' => 3
            ]);

        $handler = new ListUsersQueryHandler(
            $this->userRepository
        );

        $query = new ListUsersQuery(
            page: 1,
            pageSize: 20
        );

        $result = $handler($query);

        self::assertEquals($pagination, $result);
    }
}
