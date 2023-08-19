<?php

declare(strict_types=1);

namespace App\Application\Model\Query;

use App\Application\QueryInterface;

final class ModelQuery implements QueryInterface
{
    public function __construct(
        public readonly string $modelUuid,
    ) {
    }
}
