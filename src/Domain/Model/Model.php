<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Model
{
    private \DateTimeInterface $updatedAt;

    public function __construct(
        private string $uuid,
        private string|null $reference,
        private string $androidCodeName,
        private array $attributes,
        private Serie $serie,
        private ?Model $parentModel = null,
        private int $variant = 0,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getReference(): string|null
    {
        return $this->reference;
    }

    public function getAndroidCodeName(): string
    {
        return $this->androidCodeName;
    }

    public function setAndroidCodeName(string $androidCodeName, int $variant): void
    {
        $this->androidCodeName = $androidCodeName;
        $this->variant = $variant;
    }

    public function getVariant(): int
    {
        return $this->variant;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $date): void
    {
        $this->updatedAt = $date;
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
        return $this->serie->getName() . ' ' . $this->reference;
    }
}
