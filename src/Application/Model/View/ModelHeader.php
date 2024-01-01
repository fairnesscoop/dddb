<?php

declare(strict_types=1);

namespace App\Application\Model\View;

readonly class ModelHeader
{
    public function __construct(
        public string $uuid,
        public string|null $reference,
        public string $androidCodeName,
        public int $variant,
        public string|null $serie = null,
        public string|null $serieUuid = null,
        public string|null $manufacturer = null,
    ) {
    }
}
