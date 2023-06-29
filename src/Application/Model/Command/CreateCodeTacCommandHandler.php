<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\IdFactoryInterface;
use App\Domain\ModelEntity\Exception\CodeTacAlreadyExistsException;
use App\Domain\ModelEntity\Repository\ModelRepositoryInterface;
use App\Domain\Model\Model;

class CreateCodeTacCommandHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
        private IdFactoryInterface $idFactory,
    ) {
    }

    public function __invoke(CreateCodeTacCommand $createCodeTacCommand): Model
    {
        if ($this->modelRepository->isCodeTacUsed($createCodeTacCommand->codeTac)) {
            throw new CodeTacAlreadyExistsException();
        }

        $model = $createCodeTacCommand->model;
        $model->addCodeTac($createCodeTacCommand->codeTac);

        return $this->modelRepository->update($model);
    }
}
