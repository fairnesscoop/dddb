<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Os;

use App\Domain\Os\Os;
use PHPUnit\Framework\TestCase;

class OsTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $name = 'LineageOS';

        $os = new Os(
            $uuid,
            $name
        );

        $this->assertSame($os->getUuid(), $uuid);
        $this->assertSame($os->getName(), $name);
    }
}
