<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Attribute;

use App\Domain\Model\Attribute\Battery;
use PHPUnit\Framework\TestCase;

final class BatteryTest extends TestCase
{
    public function testGetters(): void
    {
        $references = ['1234'];

        $batteryAttribute = new Battery($references);

        $this->assertSame($batteryAttribute->getValue(), $references);
    }
}
