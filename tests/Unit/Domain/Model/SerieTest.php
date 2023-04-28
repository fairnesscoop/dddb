<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\Manufacturer;
use App\Domain\Model\Serie;
use PHPUnit\Framework\TestCase;

final class SerieTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $name = 'Pixel 5';
        $manufacturer = $this->createMock(Manufacturer::class);

        $serie = new Serie(
            $uuid,
            $name,
            $manufacturer
        );

        $this->assertSame($serie->getUuid(), $uuid);
        $this->assertSame($serie->getName(), $name);
        $this->assertSame($serie->getManufacturer(), $manufacturer);
    }
}
