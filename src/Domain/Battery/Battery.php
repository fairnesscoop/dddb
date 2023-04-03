<?php

declare(strict_types=1);

namespace App\Domain\Battery;

class Battery
{
    public function __construct(
        private string $uuid,
        private string $reference
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getReference(): string
    {
        return $this->reference;
    }
}
