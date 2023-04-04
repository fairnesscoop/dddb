<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Serie\Serie;

class Model
{
    public function __construct(
        private string $uuid,
        private string $codeName,
        private array $codeTac,
        private array $attributes,
        private Serie $serie,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCodeName(): string
    {
        return $this->codeName;
    }

    public function getCodeTac(): array
    {
        return $this->codeTac;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getSerie(): Serie
    {
        return $this->serie;
    }
}
