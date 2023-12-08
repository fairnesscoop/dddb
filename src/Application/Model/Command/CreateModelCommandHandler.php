<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\IdFactoryInterface;
use App\Domain\Model\Exception\ReferenceAlreadyExistsException;
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
        $variant = $createModelCommand->variant ?: 0;

        if (!empty($createModelCommand->reference)
            && $this->modelRepository->isReferenceUsed(
                $createModelCommand->serie->getManufacturer(),
                $createModelCommand->reference,
                $variant,
            )
        ) {
            throw new ReferenceAlreadyExistsException();
        }

        $uuid = $this->idFactory->make();

        return $this->modelRepository->add(
            new Model(
                $uuid,
                $createModelCommand->reference,
                $createModelCommand->androidCodeName,
                [],
                $createModelCommand->serie,
                $createModelCommand->parentModel,
                $variant,
            ),
        );
    }
}
