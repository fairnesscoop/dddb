<?php

namespace App\Tests\Unit\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Domain\Model\Attribute\Memo;
use App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer\MemoNormalizer;
use PHPUnit\Framework\TestCase;

class MemoNormalizerTest extends TestCase
{
    public function testNormalize(): void
    {
        $normalizer = new MemoNormalizer();
        $result = $normalizer->normalize(new Memo('Important note about model'));
        $this->assertEquals('Important note about model', $result);
    }

    public function testSupports(): void
    {
        $normalizer = new MemoNormalizer();
        $this->assertEquals(Memo::NAME, $normalizer->supports(Memo::NAME));
    }
}
