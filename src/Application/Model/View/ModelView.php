<?php

declare(strict_types=1);

namespace App\Application\Model\View;

use App\Domain\Model\Attribute\AttributeCollection;

readonly class ModelView
{
    public function __construct(
        public string $uuid,
        public string $androidCodeName,
        public int $variant,
        public string|null $reference,
        public AttributeCollection $attributes,
        public iterable $codeTacs,
    ) {
    }
}
