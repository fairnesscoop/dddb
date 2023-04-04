<?php

declare(strict_types=1);

namespace App\Domain\Serie;

use App\Domain\Constructor\Constructor;

class Serie
{
    public function __construct(
        private string $uuid,
        private string $name,
        private Constructor $constructor
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getConstructor(): Constructor
    {
        return $this->constructor;
    }
}
