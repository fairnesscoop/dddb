<?php

declare(strict_types=1);

namespace App\Application\SupportedOsList\Command;

use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\SupportedOsList;

class DeleteSupportedOsCommandHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributeRepository,
    ) {
    }

    public function __invoke(DeleteSupportedOsCommand $command): void
    {
        if (\is_null($command->supportedOsId)) {
            throw new \InvalidArgumentException('Supported OS id must be defined');
        }

        $attributes = $this->attributeRepository->getModelAttributes($command->model);

        /** @var SupportedOsList $supportedOsListAttribute */
        $supportedOsListAttribute = $attributes->get(SupportedOsList::NAME);
        $supportedOsListAttribute->deleteById($command->supportedOsId);

        $this->attributeRepository->updateModelAttribute($command->model, SupportedOsList::NAME, $supportedOsListAttribute);
    }
}
