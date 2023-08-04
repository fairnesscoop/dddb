<?php

declare(strict_types=1);

namespace App\Application\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Attribute\Memo;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Model\Model;
use Symfony\Component\DependencyInjection\Argument\ServiceLocator;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;

class AttributeGenericBuilder
{
    public function __construct(
        #[TaggedLocator(BuilderInterface::class, defaultIndexMethod: 'supports')]
        private readonly ServiceLocator $builderLocator,
    ) {
    }

    public function createAttributeCollection(array $attributes): AttributeCollection
    {
        $attributeCollection = new AttributeCollection([]);

        foreach ($attributes as $name => $value) {
            $attributeCollection->set($name, $this->createAttribute($name, $value));
        }

        return $attributeCollection;
    }

    public function createAttribute(string $attributeName, mixed $internalValue): AttributeInterface
    {
        return $this->builderLocator->get($attributeName)->createAttribute($internalValue);
    }

    public function createAttributeFromModel(Model $model, string $attributeName): AttributeInterface|null
    {
        $internalValues = $model->getAttributes();
        if (!isset($internalValues[$attributeName])) {
            return null;
        }

        return $this->createAttribute($attributeName, $internalValues[$attributeName]);
    }

    public static function getAllAttributeNames(): array
    {
        return [
            Memo::NAME,
            SupportedOsList::NAME,
            Battery::NAME,
        ];
    }
}
