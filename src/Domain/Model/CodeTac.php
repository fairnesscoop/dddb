<?php

declare(strict_types=1);

namespace App\Domain\Model;

class CodeTac
{
    public function __construct(
        private int $code,
        private Model $model,
    ) {
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
