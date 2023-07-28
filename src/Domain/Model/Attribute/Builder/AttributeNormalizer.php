<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeInterface;

class AttributeNormalizer
{
    public function normalize(AttributeCollection $attributeCollection): array
    {
        $normalizedAttributes = [];
        /* @var AttributeInterface $atribute */
        foreach ($attributeCollection as $name => $attribute) {
            $normalizedAttributes[$name] = $attribute->getValue();
        }

        return $normalizedAttributes;
    }
}
