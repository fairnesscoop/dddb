<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

use App\Domain\Model\Model;

interface AttributeRepositoryInterface
{
    public function getModelAttributes(Model $model): AttributeCollection;

    /** @return string[] */
    public function getAllAttributeNames(): array;

    public function createAttributeFromModel(Model $model, string $attributeName): ?AttributeInterface;

    public function updateModelAttribute(Model $model, string $attributeName, AttributeInterface $attribute): void;

    public function findAllAttributes(): iterable;
}
