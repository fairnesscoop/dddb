<?php

declare(strict_types=1);

namespace App\Domain\ModelEntity\Repository;

use App\Domain\Model\CodeTac;
use App\Domain\Model\Model;

interface CodeTacRepositoryInterface
{
    public function add(CodeTac $codeTac): CodeTac;

    public function remove(CodeTac $codeTac): void;

    public function isCodeTacUsed(int $codeTac): bool;

    public function findCodeTacs(Model $model): iterable;
}
