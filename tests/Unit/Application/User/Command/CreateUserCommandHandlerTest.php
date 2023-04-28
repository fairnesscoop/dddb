<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\User\Command;

use App\Application\IdFactoryInterface;
use App\Application\PasswordHasherInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Command\CreateUserCommandHandler;
use App\Domain\User\Enum\RoleEnum;
use App\Domain\User\Exception\UserAlreadyRegisteredException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\IsUserAlreadyRegistred;
use App\Domain\User\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateUserCommandHandlerTest extends TestCase
{
    private MockObject|IdFactoryInterface $idFactory;
    private MockObject|PasswordHasherInterface $passwordHasher;
    private MockObject|UserRepositoryInterface $userRepository;
    private MockObject|IsUserAlreadyRegistred $isUserAlreadyRegistred;

    public function setUp(): void
    {
        $this->idFactory = $this->createMock(IdFactoryInterface::class);
        $this->passwordHasher = $this->createMock(PasswordHasherInterface::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->isUserAlreadyRegistred = $this->createMock(IsUserAlreadyRegistred::class);
    }

    public function testRegister(): void
    {
        $uuid = '239898f3-0c1b-42bd-8b6d-d2d0c506bb86';
        $firstName = 'Benoit';
        $lastName = 'Paquier';
        $email = 'benoit@email.org';
        $hashPassword = 'hashPassword';
        $role = RoleEnum::ROLE_ADMIN;

        $createdUser = $this->createMock(User::class);

        $this->isUserAlreadyRegistred
            ->expects(self::once())
            ->method('isSatisfiedBy')
            ->with($email)
            ->willReturn(false);

        $this->idFactory
            ->expects(self::once())
            ->method('make')
            ->willReturn($uuid);

        $this->passwordHasher
            ->expects(self::once())
            ->method('hash')
            ->willReturn($hashPassword);

        $this->userRepository
            ->expects(self::once())
            ->method('add')
            ->with(
                new User(
                    uuid: $uuid,
                    firstName: $firstName,
                    lastName: $lastName,
                    email: $email,
                    password: $hashPassword,
                    role: $role
                )
            )
            ->willReturn($createdUser);

        $handler = new CreateUserCommandHandler(
            $this->userRepository,
            $this->isUserAlreadyRegistred,
            $this->idFactory,
            $this->passwordHasher
        );

        $command = new CreateUserCommand();
        $command->firstName = $firstName;
        $command->lastName = $lastName;
        $command->email = $email;
        $command->password = $hashPassword;
        $command->role = $role;

        $result = $handler($command);

        $this->assertSame($createdUser, $result);
    }

    public function testAlreadyExists(): void
    {
        $this->expectException(UserAlreadyRegisteredException::class);

        $firstName = 'Benoit';
        $lastName = 'Paquier';
        $email = 'benoit@email.org';
        $hashPassword = 'hashPassword';
        $role = RoleEnum::ROLE_ADMIN;

        $this->isUserAlreadyRegistred
            ->expects(self::once())
            ->method('isSatisfiedBy')
            ->with($email)
            ->willReturn(true);

        $this->idFactory
            ->expects(self::never())
            ->method('make');

        $this->passwordHasher
            ->expects(self::never())
            ->method('hash');

        $this->userRepository
            ->expects(self::never())
            ->method('add');

        $handler = new CreateUserCommandHandler(
            $this->userRepository,
            $this->isUserAlreadyRegistred,
            $this->idFactory,
            $this->passwordHasher
        );

        $command = new CreateUserCommand();
        $command->firstName = $firstName;
        $command->lastName = $lastName;
        $command->email = $email;
        $command->password = $hashPassword;
        $command->role = $role;

        $handler($command);
    }
}
