<?php

declare(strict_types=1);

namespace App\Application\Model\View;

readonly class ModelFlatView
{
    public function __construct(
        public string $uuid,
        public string $manufacturer,
        public string $serie,
        public string $androidCodeName,
        public int $variant,
        public ?string $reference,
        public string $parent,
    ) {
    }
}
