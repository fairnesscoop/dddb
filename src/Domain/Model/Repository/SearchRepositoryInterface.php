<?php

declare(strict_types=1);

namespace App\Domain\Model\Repository;

use App\Application\Model\View\ModelHeader;

interface SearchRepositoryInterface
{
    /** @return ModelHeader[] */
    public function search(string $query): iterable;
}
