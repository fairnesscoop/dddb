<?php

declare(strict_types=1);

namespace App\Application\SupportedOsList\Command;

use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\SupportedOs;
use App\Domain\Model\Attribute\SupportedOsList;

class AddSupportedOsCommandHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributeRepository,
    ) {
    }

    public function __invoke(AddSupportedOsCommand $command): void
    {
        if (empty($command->osVersion)) {
            throw new \InvalidArgumentException('OS version must be defined');
        }

        $attributes = $this->attributeRepository->getModelAttributes($command->model);

        if ($attributes->has(SupportedOsList::NAME)) {
            /** @var SupportedOsList $supportedOsListAttribute */
            $supportedOsListAttribute = $attributes->get(SupportedOsList::NAME);
            $newSupportedOs = $this->createSupportedOs($this->getNextId($supportedOsListAttribute), $command);
            $supportedOsListAttribute->add($newSupportedOs);
        } else {
            $newSupportedOs = $this->createSupportedOs(1, $command);
            $supportedOsListAttribute = new SupportedOsList([$newSupportedOs]);
        }

        $this->attributeRepository->updateModelAttribute($command->model, SupportedOsList::NAME, $supportedOsListAttribute);
    }

    private function createSupportedOs(int $osId, AddSupportedOsCommand $command): SupportedOs
    {
        return new SupportedOs(
            $osId,
            $command->osVersion,
            $command->helpLink,
            $command->comment,
            $command->recoveryFileUrl,
            $command->romFileUrl,
        );
    }

    private function getNextId(SupportedOsList $attribute): int
    {
        $nextId = 1;
        foreach ($attribute->getValue() as $supportedOs) {
            if ($supportedOs->id >= $nextId) {
                $nextId = $supportedOs->id + 1;
            }
        }

        return $nextId;
    }
}
