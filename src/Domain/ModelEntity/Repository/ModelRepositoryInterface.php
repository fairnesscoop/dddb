<?php

declare(strict_types=1);

namespace App\Domain\ModelEntity\Repository;

use App\Domain\Model\Manufacturer;
use App\Domain\Model\Model;
use App\Domain\Model\Serie;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface ModelRepositoryInterface
{
    public function add(Model $model): Model;

    public function update(Model $model): Model;

    public function isCodeNameUsed(Manufacturer $manufacturer, string $codeName): bool;

    public function isCodeTacUsed(string $codeTac): bool;

    public function findModels(Serie $serie, int $page, int $pageSize): Paginator;
}
