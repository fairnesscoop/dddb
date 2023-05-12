<?php

declare(strict_types=1);

namespace App\Application\Serie\Command;

use App\Application\IdFactoryInterface;
use App\Domain\Model\Serie;
use App\Domain\Serie\Exception\NameAlreadyExistsException;
use App\Domain\Serie\Repository\SerieRepositoryInterface;

class CreateSerieCommandHandler
{
    public function __construct(
        private SerieRepositoryInterface $serieRepository,
        private IdFactoryInterface $idFactory,
    ) {
    }

    public function __invoke(CreateSerieCommand $createSerieCommand): Serie
    {
        if ($this->serieRepository->isNameUsed($createSerieCommand->manufacturer, $createSerieCommand->name)) {
            throw new NameAlreadyExistsException();
        }

        $uuid = $this->idFactory->make();

        return $this->serieRepository->add(
            new Serie(
                $uuid,
                $createSerieCommand->name,
                $createSerieCommand->manufacturer,
            ),
        );
    }
}
