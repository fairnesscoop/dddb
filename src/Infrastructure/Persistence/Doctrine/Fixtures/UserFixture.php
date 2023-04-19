<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Domain\User\Enum\RoleEnum;
use App\Domain\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $bpaquier = new User(
            '0b507871-8b5e-4575-b297-a630310fc06e',
            'Benoit',
            'Paquier',
            'benoit.paquier@fairness.coop',
            'password',
            RoleEnum::ROLE_ADMIN,
        );

        $manager->persist($bpaquier);
        $manager->flush();

        $this->addReference('bpaquier', $bpaquier);
    }
}
