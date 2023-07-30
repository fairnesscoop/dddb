<?php

declare(strict_types=1);

namespace App\Application\Attribute\Normalizer;

use App\Domain\Model\Attribute\AttributeCollection;

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
