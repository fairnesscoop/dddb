<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Domain\Model\CodeTac;
use App\Domain\Model\Exception\CodeTacAlreadyExistsException;
use App\Domain\Model\Repository\CodeTacRepositoryInterface;

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
