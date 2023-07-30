<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Attribute;

use App\Domain\Model\Attribute\SupportedOs;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Os\OsVersionList;
use PHPUnit\Framework\TestCase;

final class SupportedOsListTest extends TestCase
{
    public function testGetters(): void
    {
        $osVersionList = new OsVersionList();
        $supportedOsListValues = [new SupportedOs(1, $osVersionList->getById(3), 'https://example.com/2', 'Sample comment')];

        $supportedOsList = new SupportedOsList($supportedOsListValues);

        $this->assertSame($supportedOsList->getValue(), $supportedOsListValues);
    }
}
