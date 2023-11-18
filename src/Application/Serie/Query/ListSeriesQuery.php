<?php

declare(strict_types=1);

namespace App\Application\Serie\Query;

use App\Application\QueryInterface;

final class ListSeriesQuery implements QueryInterface
{
    public function __construct(
        public readonly int $page,
        public readonly int $pageSize,
        public readonly string|null $manufacturerUuid,
    ) {
    }
}
