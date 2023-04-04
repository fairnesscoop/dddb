<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User;

use App\Domain\Battery\Battery;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcd';
        $reference = 'efgh';

        $battery = new Battery(
            $uuid,
            $reference
        );

        $this->assertSame($battery->getUuid(), $uuid);
        $this->assertSame($battery->getReference(), $reference);
    }
}
