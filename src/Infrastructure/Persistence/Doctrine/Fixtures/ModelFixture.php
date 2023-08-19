<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Attribute\Memo;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Model\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ModelFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [SerieFixture::class];
    }

    public function load(ObjectManager $manager): void
    {
        $fairphone4Serie = $this->getReference('fairphone4');
        $fp4Model = new Model(
            'b4b0f83d-b70a-461d-a822-1f4451111efc',
            'FP4',
            [
                Memo::NAME => 'Memo example',
                SupportedOsList::NAME => [
                    [
                        'id' => 1,
                        'comment' => null,
                        'helpLink' => 'https://wiki.lineageos.org/devices/FP4/',
                        'osVersionId' => 2,
                    ],
                ],
                Battery::NAME => ['FP4-BATT-2012'],
            ],
            $fairphone4Serie,
        );

        $manager->persist($fp4Model);
        $manager->flush();

        $this->addReference('fp4', $fp4Model);
    }
}
