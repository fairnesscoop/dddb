<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Serie;

use App\Domain\Constructor\Constructor;
use App\Domain\Serie\Serie;
use PHPUnit\Framework\TestCase;

final class SerieTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $name = 'Pixel 5';
        $constructor = $this->createMock(Constructor::class);

        $serie = new Serie(
            $uuid,
            $name,
            $constructor
        );

        $this->assertSame($serie->getUuid(), $uuid);
        $this->assertSame($serie->getName(), $name);
        $this->assertSame($serie->getConstructor(), $constructor);
    }
}
