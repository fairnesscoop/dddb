<?php

declare(strict_types=1);

namespace App\Application\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\DerivedAttribute;
use App\Domain\Model\Model;

/**
 * Build attribute collection with attributes derived from parents when undefined
 */
class MergedAttributesBuilder
{
    public function __construct(
        private readonly AttributeRepositoryInterface $attributeRepository,
    ) {
    }

    public function getMergedAttributes(Model $model): AttributeCollection
    {
        if ($model->getParentModel() === null) {
            return $this->attributeRepository->getModelAttributes($model);
        }

        return $this->mergeAttributes($model);
    }

    private function mergeAttributes(Model $model): AttributeCollection
    {
        $parentAttributes = $this->getMergedAttributes($model->getParentModel());
        $mergedAttributes = $this->attributeRepository->getModelAttributes($model);

        foreach ($parentAttributes as $name => $parentAttribute) {
            if (!$mergedAttributes->has($name)) {
                $mergedAttributes->set($name, new DerivedAttribute($parentAttribute));
            }
        }

        return $mergedAttributes;
    }
}
