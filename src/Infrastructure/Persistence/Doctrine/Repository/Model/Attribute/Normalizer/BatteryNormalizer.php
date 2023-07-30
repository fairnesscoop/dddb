<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Application\Attribute\Normalizer\NormalizerInterface;
use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\Battery;

class BatteryNormalizer implements NormalizerInterface
{
    public function normalize(AttributeInterface $attribute): array
    {
        return $attribute->getValue();
    }

    public static function supports(): string
    {
        return Battery::NAME;
    }
}
