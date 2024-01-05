<?php

declare(strict_types=1);

namespace App\Application\Model\Query;

use App\Application\QueryInterface;

final class SearchQuery implements QueryInterface
{
    public function __construct(
        public readonly string $search,
    ) {
    }
}
