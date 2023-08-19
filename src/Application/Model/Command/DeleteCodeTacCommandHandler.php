<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Domain\Model\Repository\CodeTacRepositoryInterface;

class DeleteCodeTacCommandHandler
{
    public function __construct(
        private CodeTacRepositoryInterface $codeTacRepository,
    ) {
    }

    public function __invoke(DeleteCodeTacCommand $command): void
    {
        $code = (int) $command->codeTac;

        $this->codeTacRepository->remove($code);
    }
}
