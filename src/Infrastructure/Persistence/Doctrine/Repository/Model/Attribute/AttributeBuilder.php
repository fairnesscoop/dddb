<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute;

use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Model;
use App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Denormalizer\DenormalizerInterface;
use Symfony\Component\DependencyInjection\Argument\ServiceLocator;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;

class AttributeBuilder
{
    public function __construct(
        #[TaggedLocator(DenormalizerInterface::class, defaultIndexMethod: 'supports')]
        private readonly ServiceLocator $denormalizerLocator,
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

    private function createAttribute(string $attributeName, mixed $internalValue): AttributeInterface
    {
        return $this->denormalizerLocator->get($attributeName)->createAttribute($internalValue);
    }

    public function createAttributeFromModel(Model $model, string $attributeName): AttributeInterface|null
    {
        $internalValues = $model->getAttributes();
        if (!isset($internalValues[$attributeName])) {
            return null;
        }

        return $this->createAttribute($attributeName, $internalValues[$attributeName]);
    }
}
