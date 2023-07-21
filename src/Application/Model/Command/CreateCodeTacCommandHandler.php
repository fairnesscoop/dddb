<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Domain\Model\CodeTac;
use App\Domain\ModelEntity\Exception\CodeTacAlreadyExistsException;
use App\Domain\ModelEntity\Repository\CodeTacRepositoryInterface;

class CreateCodeTacCommandHandler
{
    public function __construct(
        private CodeTacRepositoryInterface $codeTacRepository,
    ) {
    }

    public function __invoke(CreateCodeTacCommand $createCodeTacCommand): CodeTac
    {
        $code = (int) $createCodeTacCommand->codeTac;

        if ($this->codeTacRepository->isCodeTacUsed($code)) {
            throw new CodeTacAlreadyExistsException();
        }

        $codeTacEntity = new CodeTac($code, $createCodeTacCommand->model);

        return $this->codeTacRepository->add($codeTacEntity);
    }
}
