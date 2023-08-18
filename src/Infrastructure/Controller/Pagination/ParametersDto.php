<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Pagination;

readonly class ParametersDto
{
    public function __construct(
        public int $page,
        public int $pageSize,
    ) {
    }
}
