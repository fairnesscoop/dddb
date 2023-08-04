<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

use App\Domain\Model\Model;

interface AttributeRepositoryInterface
{
    public function getModelAttributes(Model $model): AttributeCollection;

    public function updateModelAttribute(Model $model, string $attributeName, AttributeInterface $attribute): void;
}
