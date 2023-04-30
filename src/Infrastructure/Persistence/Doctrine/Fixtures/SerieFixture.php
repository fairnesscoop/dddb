<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Domain\Model\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class SerieFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ManufacturerFixture::class];
    }

    public function load(ObjectManager $manager): void
    {
        $fairphone = $this->getReference('fairphone');
        $fairphone4 = new Serie(
            '12134585-b6c4-444b-8dc3-2a17a0693e5c',
            'Model 4',
            $fairphone,
        );

        $manager->persist($fairphone4);
        $manager->flush();

        $this->addReference('fairphone4', $fairphone4);
    }
}
