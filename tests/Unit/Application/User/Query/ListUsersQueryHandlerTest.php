<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\User\Query;

use App\Application\User\Query\ListUsersQuery;
use App\Application\User\Query\ListUsersQueryHandler;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class ListUsersQueryHandlerTest extends TestCase
{
    private $userRepository;

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
                "email" => "benoit.paquier@fairness.coop",
                "role" => "ROLE_ADMIN"
            ],
            [
                "uuid" => "abcde",
                "firstName" => "Gregory",
                "lastName" => "Pelletier",
                "email" => "gregory.pelletier@fairness.coop",
                "role" => "ROLE_ADMIN"
            ],
            [
                "uuid" => "abcde",
                "firstName" => "Mathieu",
                "lastName" => "Marchois",
                "email" => "benoit.paquier@fairness.coop",
                "role" => "ROLE_ADMIN"
            ],
        ];

        $this->userRepository
            ->expects(self::once())
            ->method('findUsers')
            ->willReturn($users);

        $handler = new ListUsersQueryHandler(
            $this->userRepository
        );

        $query = new ListUsersQuery();

        $result = $handler($query);

        $this->assertSame($users, $result);
    }
}
