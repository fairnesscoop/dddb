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
            'benoit@email.org',
            'password',
            RoleEnum::ROLE_ADMIN,
        );

        $gpelletier = new User(
            '0b507871-8b5e-4575-b297-a630310fc06a',
            'Gregory',
            'Pelletier',
            'gregory@email.org',
            'password',
            RoleEnum::ROLE_ADMIN,
        );

        $mmarchois = new User(
            '0b507871-8b5e-4575-b297-a630310fc06b',
            'Mathieu',
            'Marchois',
            'mathieu@email.org',
            'password',
            RoleEnum::ROLE_ADMIN,
        );

        $manager->persist($bpaquier);
        $manager->persist($gpelletier);
        $manager->persist($mmarchois);
        $manager->flush();

        $this->addReference('bpaquier', $bpaquier);
        $this->addReference('gpelletier', $gpelletier);
        $this->addReference('mmarchois', $mmarchois);
    }
}
