<?php

declare(strict_types=1);

namespace App\Application\Battery\Command;

use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\Battery;

class AddBatteryReferenceCommandHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributeRepository,
    ) {
    }

    public function __invoke(AddBatteryReferenceCommand $command): void
    {
        if (empty($command->batteryReference)) {
            throw new \InvalidArgumentException('Battery reference must not be empty');
        }

        $attributes = $this->attributeRepository->getModelAttributes($command->model);

        if ($attributes->has(Battery::NAME)) {
            /** @var Battery $batteryAttribute */
            $batteryAttribute = $attributes->get(Battery::NAME);
            $updatedBatteryReferences = array_unique([...$batteryAttribute->getValue(), $command->batteryReference]);
        } else {
            $updatedBatteryReferences = [$command->batteryReference];
        }

        $this->attributeRepository->updateModelAttribute($command->model, Battery::NAME, new Battery($updatedBatteryReferences));
    }
}
