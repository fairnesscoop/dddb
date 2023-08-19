<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\IdFactoryInterface;
use App\Domain\Model\Exception\CodeNameAlreadyExistsException;
use App\Domain\Model\Model;
use App\Domain\Model\Repository\ModelRepositoryInterface;

class CreateModelCommandHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
        private IdFactoryInterface $idFactory,
    ) {
    }

    public function __invoke(CreateModelCommand $createModelCommand): Model
    {
        if ($this->modelRepository->isCodeNameUsed($createModelCommand->serie->getManufacturer(), $createModelCommand->codeName)) {
            throw new CodeNameAlreadyExistsException();
        }

        $uuid = $this->idFactory->make();

        return $this->modelRepository->add(
            new Model(
                $uuid,
                $createModelCommand->codeName,
                [],
                $createModelCommand->serie,
                $createModelCommand->parentModel,
            ),
        );
    }
}
