<?php

declare(strict_types=1);

namespace App\Application\Model\Query;

use App\Application\QueryInterface;
use App\Domain\Model\Serie;

final class ListSerieModelsQuery implements QueryInterface
{
    public function __construct(
        public readonly Serie $serie,
    ) {
    }
}
