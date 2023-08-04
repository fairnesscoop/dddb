<?php

declare(strict_types=1);

namespace App\Application\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\Memo;

class MemoBuilder implements BuilderInterface
{
    public function createAttribute(mixed $value): AttributeInterface
    {
        return new Memo($value);
    }

    public static function supports(): string
    {
        return Memo::NAME;
    }
}
