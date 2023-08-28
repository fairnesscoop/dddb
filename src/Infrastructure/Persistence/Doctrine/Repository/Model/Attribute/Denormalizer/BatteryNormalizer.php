<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Denormalizer;

use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\Battery;

class BatteryNormalizer implements DenormalizerInterface
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
