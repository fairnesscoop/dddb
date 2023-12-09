<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Domain\Model\Model;
use App\Domain\Model\Repository\ModelRepositoryInterface;

class SetAndroidCodeNameCommandHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
    ) {
    }

    public function __invoke(SetAndroidCodeNameCommand $command): Model
    {
        $command->model->setAndroidCodeName($command->androidCodeName, $command->variant);

        return $this->modelRepository->update($command->model);
    }
}
