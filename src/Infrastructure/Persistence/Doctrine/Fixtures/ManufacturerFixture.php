<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Domain\Model\Manufacturer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ManufacturerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fairphone = new Manufacturer(
            '46918802-8e1c-4959-a201-bda5e41141b8',
            'Fairphone',
        );

        $manager->persist($fairphone);
        $manager->flush();

        $this->addReference('fairphone', $fairphone);
    }
}
