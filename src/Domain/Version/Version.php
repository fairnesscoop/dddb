<?php

declare(strict_types=1);

namespace App\Domain\Version;

use App\Domain\Os\Os;

class Version
{
    public function __construct(
        private string $uuid,
        private string $name,
        private Os $os
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

    public function getOs(): Os
    {
        return $this->os;
    }
}
