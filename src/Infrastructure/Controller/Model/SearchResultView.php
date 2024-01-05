<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

class SearchResultView
{
    public function __construct(
        public readonly iterable $models,
        public readonly string $searchQuery,
    ) {
    }
}
