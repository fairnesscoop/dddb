<?php

namespace App\Tests\Unit\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Domain\Model\Attribute\Battery;
use App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer\BatteryNormalizer as NormalizerBatteryNormalizer;
use PHPUnit\Framework\TestCase;

class BatteryNormalizerTest extends TestCase
{
    public function testNormalize(): void
    {
        $normalizer = new NormalizerBatteryNormalizer();
        $result = $normalizer->normalize(new Battery(['REF-123']));
        $this->assertEquals(['REF-123'], $result);
    }

    public function testSupports(): void
    {
        $normalizer = new NormalizerBatteryNormalizer();
        $this->assertEquals(Battery::NAME, $normalizer->supports(Battery::NAME));
    }
}
