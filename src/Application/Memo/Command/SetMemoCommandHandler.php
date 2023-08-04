<?php

declare(strict_types=1);

namespace App\Application\Memo\Command;

use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\Memo;

class SetMemoCommandHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributeRepository,
    ) {
    }

    public function __invoke(SetMemoCommand $command): void
    {
        if (empty($command->text)) {
            throw new \InvalidArgumentException('Memo text must not be empty');
        }

        $this->attributeRepository->updateModelAttribute($command->model, Memo::NAME, new Memo($command->text));
    }
}
