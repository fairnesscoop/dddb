<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Serie
{
    public function __construct(
        private string $uuid,
        private string $name,
        private Manufacturer $manufacturer,
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

    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    public function __toString(): string
    {
        return $this->name . ' ' . $this->manufacturer->getName();
    }
}
