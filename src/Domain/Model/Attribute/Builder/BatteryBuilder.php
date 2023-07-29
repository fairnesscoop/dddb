<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\Battery;

class BatteryBuilder implements BuilderInterface
{
    public function createAttribute(mixed $value): AttributeInterface
    {
        return new Battery($value);
    }

    public static function supports(): string
    {
        return Battery::NAME;
    }
}
