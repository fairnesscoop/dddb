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

        $contributor = new User(
            '01f45a01-3579-4b6f-a1e8-49825c32a1f6',
            'John',
            'Doe',
            'contrib@vertige.org',
            'test',
            RoleEnum::ROLE_CONTRIBUTOR,
        );

        $admin = new User(
            '6b9b6115-7085-4fe2-b5ee-24c40066cb18',
            'Tim',
            'Lee',
            'admin@vertige.org',
            'test',
            RoleEnum::ROLE_ADMIN,
        );

        $manager->persist($bpaquier);
        $manager->persist($gpelletier);
        $manager->persist($mmarchois);
        $manager->persist($contributor);
        $manager->persist($admin);
        $manager->flush();

        $this->addReference('bpaquier', $bpaquier);
        $this->addReference('gpelletier', $gpelletier);
        $this->addReference('mmarchois', $mmarchois);
        $this->addReference('contributor', $contributor);
        $this->addReference('admin', $admin);
    }
}
