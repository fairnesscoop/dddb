<?php

namespace App\Tests\Unit\Domain\Constructor;

use App\Domain\Constructor\Constructor;
use PHPUnit\Framework\TestCase;

final class ConstructorTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $name = 'Fairphone';

        $constructor = new Constructor(
            $uuid,
            $name
        );

        $this->assertSame($constructor->getUuid(), $uuid);
        $this->assertSame($constructor->getName(), $name);
    }
}
