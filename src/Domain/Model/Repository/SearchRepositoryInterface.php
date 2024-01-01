<?php

declare(strict_types=1);

namespace App\Domain\Model\Repository;

interface SearchRepositoryInterface
{
    public function search(string $query): iterable;
}
