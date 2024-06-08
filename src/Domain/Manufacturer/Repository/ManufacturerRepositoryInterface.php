<?php

declare(strict_types=1);

namespace App\Domain\Manufacturer\Repository;

use App\Domain\Model\Manufacturer;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface ManufacturerRepositoryInterface
{
    public function add(Manufacturer $manufacturer): Manufacturer;

    public function isNameUsed(string $name): bool;

    public function findManufacturers(int $page, int $pageSize): Paginator;

    public function findUuidByName(string $name): ?string;
}
