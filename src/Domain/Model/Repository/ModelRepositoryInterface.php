<?php

declare(strict_types=1);

namespace App\Domain\Model\Repository;

use App\Application\Model\View\ModelFlatView;
use App\Application\Model\View\ModelHeader;
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

    public function findModelByUuid(string $modelUuid): Model|null;

    public function findModelByCodeName(string $serieUuid, string $codeName): Model|null;

    public function findPaginatedModels(Serie $serie, int $page, int $pageSize): Paginator;

    /** @return ModelHeader[] */
    public function findAllModelHeaders(Serie $serie): iterable;

    /** @return ModelFlatView[] */
    public function findAllModels(): iterable;
}
