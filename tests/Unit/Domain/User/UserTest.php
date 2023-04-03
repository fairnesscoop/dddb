<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User;

use App\Domain\User\Enum\RoleEnum;
use App\Domain\User\User;

use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
  public function testGetters(): void
  {
    $uuid = 'abcd';
    $firstName = 'Benoit';
    $lastName = 'Paquier';
    $email = 'benoit.paquier@fairness.coop';
    $password = 'pwd';
    $role = RoleEnum::ADMIN;

    $user = new User(
      $uuid,
      $firstName,
      $lastName,
      $email,
      $password,
      $role
    );

    $this->assertSame($user->getUuid(), $uuid);
    $this->assertSame($user->getFirstName(), $firstName);
    $this->assertSame($user->getLastName(), $lastName);
    $this->assertSame($user->getEmail(), $email);
    $this->assertSame($user->getPassword(), $password);
    $this->assertSame($user->getRole(), $role);
  }
}
