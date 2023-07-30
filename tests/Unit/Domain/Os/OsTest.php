<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Os;

use App\Domain\Os\Os;
use PHPUnit\Framework\TestCase;

final class OsTest extends TestCase
{
    public function testGetters(): void
    {
        $id = 42;
        $name = 'Android';

        $os = new Os(
            $id,
            $name
        );

        $this->assertSame($os->getId(), $id);
        $this->assertSame($os->getName(), $name);
    }
}
