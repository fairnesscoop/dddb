<?php

declare(strict_types=1);

namespace App\Application\Manufacturer\Command;

use App\Application\IdFactoryInterface;
use App\Domain\Manufacturer\Exception\NameAlreadyExistsException;
use App\Domain\Manufacturer\Repository\ManufacturerRepositoryInterface;
use App\Domain\Model\Manufacturer;

class CreateManufacturerCommandHandler
{
    public function __construct(
        private ManufacturerRepositoryInterface $manufacturerRepository,
        private IdFactoryInterface $idFactory,
    ) {
    }

    public function __invoke(CreateManufacturerCommand $createUserCommand): Manufacturer
    {
        if ($this->manufacturerRepository->isNameUsed($createUserCommand->name)) {
            throw new NameAlreadyExistsException();
        }

        $uuid = $this->idFactory->make();

        return $this->manufacturerRepository->add(
            new Manufacturer(
                $uuid,
                $createUserCommand->name,
            ),
        );
    }
}
