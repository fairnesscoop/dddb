<?php

declare(strict_types=1);

namespace App\Application\Manufacturer\Query;

use App\Application\QueryInterface;

final class ListManufacturersQuery implements QueryInterface
{
    public function __construct(
        public readonly int $page,
        public readonly int $pageSize,
    ) {
    }
}
