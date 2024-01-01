<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Search;

use App\Domain\Model\Model;

class Term
{
    public function __construct(
        private readonly string $word,
        private readonly Model $model,
    ) {
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
