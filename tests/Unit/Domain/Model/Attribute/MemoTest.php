<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Attribute;

use App\Domain\Model\Attribute\Memo;
use PHPUnit\Framework\TestCase;

final class MemoTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcd';
        $text = 'Hello world';

        $memo = new Memo(
            $text
        );

        $this->assertSame($memo->getValue(), $text);
    }
}
