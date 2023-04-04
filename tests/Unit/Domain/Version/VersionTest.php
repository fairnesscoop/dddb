<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Version;

use App\Domain\Os\Os;
use App\Domain\Version\Version;
use PHPUnit\Framework\TestCase;

final class VersionTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $name = 'Version name';
        $os = $this->createMock(Os::class);

        $version = new Version(
            $uuid,
            $name,
            $os
        );

        $this->assertSame($version->getUuid(), $uuid);
        $this->assertSame($version->getName(), $name);
        $this->assertSame($version->getOs(), $os);
    }
}
