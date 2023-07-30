<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Os;

use App\Domain\Os\Os;
use App\Domain\Os\Version;
use PHPUnit\Framework\TestCase;

final class VersionTest extends TestCase
{
    public function testGetters(): void
    {
        $id = 3;
        $name = '12';
        $os = $this->createMock(Os::class);

        $version = new Version(
            $id,
            $name,
            $os
        );

        $this->assertSame($version->getId(), $id);
        $this->assertSame($version->getName(), $name);
        $this->assertSame($version->getOs(), $os);
    }
}
