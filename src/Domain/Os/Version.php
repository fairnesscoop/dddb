<?php

declare(strict_types=1);

namespace App\Domain\Os;

class Version
{
    public function __construct(
        private int $id,
        private string $name,
        private Os $os,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFullName(): string
    {
        return \sprintf('%s %s', $this->os->getName(), $this->name);
    }

    public function getOs(): Os
    {
        return $this->os;
    }
}
