<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Application\Attribute\Normalizer\NormalizerInterface;
use App\Domain\Model\Attribute\AttributeInterface;

abstract class BaseNormalizer implements NormalizerInterface
{
    public function normalize(AttributeInterface $attribute): array|string
    {
        return $attribute->getValue();
    }
}
