<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Model
{
    public function __construct(
        private string $uuid,
        private string $codeName,
        private array $attributes,
        private Serie $serie,
        private ?Model $parentModel = null,
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

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getSerie(): Serie
    {
        return $this->serie;
    }

    public function getParentModel(): ?Model
    {
        return $this->parentModel;
    }

    public function __toString(): string
    {
        return $this->serie->getName() . ' ' . $this->codeName;
    }
}
