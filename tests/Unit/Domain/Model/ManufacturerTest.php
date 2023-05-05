<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\Manufacturer;
use PHPUnit\Framework\TestCase;

final class ManufacturerTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $name = 'Google';

        $manufacturer = new Manufacturer(
            $uuid,
            $name
        );

        $this->assertSame($manufacturer->getUuid(), $uuid);
        $this->assertSame($manufacturer->getName(), $name);
    }
}
