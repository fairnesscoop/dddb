<?php

declare(strict_types=1);

namespace App\Application\Serie\View;

readonly class SerieHeader
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $manufacturer,
    ) {
    }
}
