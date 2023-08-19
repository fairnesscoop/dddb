<?php

declare(strict_types=1);

namespace App\Application\Model\View;

use App\Domain\Model\Attribute\AttributeCollection;

readonly class ModelView
{
    public function __construct(
        public string $uuid,
        public string $codeName,
        public AttributeCollection $attributes,
        public iterable $codeTacs,
    ) {
    }
}
