<?php

declare(strict_types=1);

namespace App\Application\Battery\Command;

use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Attribute\Builder\AttributeGenericBuilder;
use App\Domain\Model\Attribute\Builder\AttributeNormalizer;
use App\Domain\Model\Model;
use App\Domain\ModelEntity\Repository\ModelRepositoryInterface;

class AddBatteryReferenceCommandHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
        private AttributeGenericBuilder $attributeBuilder,
        private readonly AttributeNormalizer $attributeNormalizer,
    ) {
    }

    public function __invoke(AddBatteryReferenceCommand $command): Model
    {
        if (empty($command->batteryReference)) {
            throw new \InvalidArgumentException('Battery reference must not be empty');
        }

        $attributes = $this->attributeBuilder->createAttributeCollection($command->model->getAttributes());
        if ($attributes->has(Battery::NAME)) {
            /** @var Battery $batteryAttribute */
            $batteryAttribute = $attributes->get(Battery::NAME);
            $updatedBatteryReferences = array_unique([...$batteryAttribute->getValue(), $command->batteryReference]);
        } else {
            $updatedBatteryReferences = [$command->batteryReference];
        }

        $attributes->set(Battery::NAME, $this->attributeBuilder->createAttribute(Battery::NAME, $updatedBatteryReferences));

        $command->model->setAttributes($this->attributeNormalizer->normalize($attributes));

        return $this->modelRepository->update($command->model);
    }
}
