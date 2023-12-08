<?php

declare(strict_types=1);

namespace App\Domain\Serie\Repository;

use App\Domain\Model\Manufacturer;
use App\Domain\Model\Serie;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface SerieRepositoryInterface
{
    public function add(Serie $serie): Serie;

    public function isNameUsed(Manufacturer $manufacturer, string $name): bool;

    public function findPaginatedSeries(int $page, int $pageSize, string|null $manufacturerUuid): Paginator;

    public function findUuidByName(string $manufacturerUuid, string $name): string|null;

    public function findAllSerieHeaders(): iterable;
}
