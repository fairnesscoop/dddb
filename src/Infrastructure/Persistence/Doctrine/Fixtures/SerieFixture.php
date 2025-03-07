<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Domain\Model\Manufacturer;
use App\Domain\Model\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class SerieFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [ManufacturerFixture::class];
    }

    public function load(ObjectManager $manager): void
    {
        $fairphone = $this->getReference('fairphone', Manufacturer::class);
        $fairphone4 = new Serie(
            '12134585-b6c4-444b-8dc3-2a17a0693e5c',
            'Serie 4',
            $fairphone,
        );

        $manager->persist($fairphone4);

        $fairphone = $this->getReference('fairphone', Manufacturer::class);
        $fairphone3 = new Serie(
            '963c1b4e-7a0c-452e-88a0-d3a583f78b8e',
            'Serie 3',
            $fairphone,
        );

        $manager->persist($fairphone3);

        $google = $this->getReference('google', Manufacturer::class);
        $pixel = new Serie(
            'fe9881a2-58a0-40ff-acac-14c276ce15f1',
            'Pixel',
            $google,
        );

        $manager->persist($pixel);

        $manager->flush();

        $this->addReference('fairphone4', $fairphone4);
    }
}
