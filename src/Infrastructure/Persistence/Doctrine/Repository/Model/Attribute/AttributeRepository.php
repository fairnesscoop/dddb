<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute;

use App\Application\Attribute\Normalizer\NormalizerInterface;
use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Attribute\Memo;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Model\Model;
use App\Domain\Model\Repository\ModelRepositoryInterface;
use Symfony\Component\DependencyInjection\Argument\ServiceLocator;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;

class AttributeRepository implements AttributeRepositoryInterface
{
    public function __construct(
        private readonly AttributeBuilder $attributeBuilder,
        private readonly ModelRepositoryInterface $modelRepository,
        #[TaggedLocator(NormalizerInterface::class, defaultIndexMethod: 'supports')]
        private readonly ServiceLocator $attributeNormalizerLocator,
    ) {
    }

    public function getModelAttributes(Model $model): AttributeCollection
    {
        return $this->attributeBuilder->createAttributeCollection($model->getAttributes());
    }

    public function getAllAttributeNames(): array
    {
        return [
            Memo::NAME,
            SupportedOsList::NAME,
            Battery::NAME,
        ];
    }

    public function createAttributeFromModel(Model $model, string $attributeName): AttributeInterface|null
    {
        return $this->attributeBuilder->createAttributeFromModel($model, $attributeName);
    }

    public function updateModelAttribute(Model $model, string $attributeName, AttributeInterface $attribute): void
    {
        $attributes = $model->getAttributes();
        $attributes[$attributeName] = $this->attributeNormalizerLocator->get($attributeName)->normalize($attribute);
        $model->setAttributes($attributes);

        $this->modelRepository->update($model);
    }
}
