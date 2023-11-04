<?php

declare(strict_types=1);

namespace App\Application\Attribute\View;

readonly class AttributeFlatView
{
    public function __construct(
        public string $modelUuid,
        public string $name,
        public string $value,
    ) {
    }
}
