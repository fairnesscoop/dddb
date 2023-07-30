<?php

declare(strict_types=1);

namespace App\Application\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Attribute\SupportedOsList;
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

    public static function getAllAttributeNames(): array
    {
        return [
            SupportedOsList::NAME,
            Battery::NAME,
        ];
    }
}
