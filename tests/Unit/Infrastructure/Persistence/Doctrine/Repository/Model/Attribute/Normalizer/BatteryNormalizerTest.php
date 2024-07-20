<?php

namespace App\Tests\Unit\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Domain\Model\Attribute\Battery;
use App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer\BatteryNormalizer;
use PHPUnit\Framework\TestCase;

class BatteryNormalizerTest extends TestCase
{
    public function testNormalize(): void
    {
        $normalizer = new BatteryNormalizer();
        $result = $normalizer->normalize(new Battery(['REF-123']));
        self::assertEquals(['REF-123'], $result);
    }

    public function testSupports(): void
    {
        $normalizer = new BatteryNormalizer();
        self::assertEquals(Battery::NAME, $normalizer->supports(Battery::NAME));
    }
}
