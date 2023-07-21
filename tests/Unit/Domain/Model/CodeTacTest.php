<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\CodeTac;
use App\Domain\Model\Model;
use PHPUnit\Framework\TestCase;

final class CodeTacTest extends TestCase
{
    public function testGetters(): void
    {
        $code = 12345678;
        $model = $this->createMock(Model::class);

        $codeTac = new CodeTac(
            $code,
            $model,
        );

        $this->assertSame($codeTac->getCode(), $code);
        $this->assertSame($codeTac->getModel(), $model);
    }
}
