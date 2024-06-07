<?php

declare(strict_types=1);

namespace App\Application\Model\View;

readonly class ModelHeader
{
    public function __construct(
        public string $uuid,
        public ?string $reference,
        public string $androidCodeName,
        public int $variant,
        public ?string $serie = null,
        public ?string $serieUuid = null,
        public ?string $manufacturer = null,
    ) {
    }
}
