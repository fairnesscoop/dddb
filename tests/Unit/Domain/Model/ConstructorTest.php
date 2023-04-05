<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\Constructor;
use PHPUnit\Framework\TestCase;

final class ConstructorTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $name = 'Google';

        $constructor = new Constructor(
            $uuid,
            $name
        );

        $this->assertSame($constructor->getUuid(), $uuid);
        $this->assertSame($constructor->getName(), $name);
    }
}
