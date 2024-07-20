<?php

namespace App\Tests\Unit\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Domain\Model\Attribute\SupportedOs;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Os\OsVersionList;
use App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer\SupportedOsListNormalizer;
use PHPUnit\Framework\TestCase;

class SupportedOsListNormalizerTest extends TestCase
{
    public function testNormalize(): void
    {
        $osVersionList = new OsVersionList();
        $supportedOsList = new SupportedOsList([new SupportedOs(42, $osVersionList->getById(1), 'http://example.com', 'Hello world')]);

        $normalizer = new SupportedOsListNormalizer();
        $result = $normalizer->normalize($supportedOsList);
        self::assertEquals([[
            'id' => 42,
            'osVersionId' => 1,
            'helpLink' => 'http://example.com',
            'comment' => 'Hello world',
            'recoveryIpfsCid' => null,
            'romIpfsCid' => null,
        ]], $result);
    }

    public function testSupports(): void
    {
        $normalizer = new SupportedOsListNormalizer();
        self::assertEquals(SupportedOsList::NAME, $normalizer->supports());
    }
}
