<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

class Battery implements AttributeInterface
{
    public const NAME = 'battery';

    public function __construct(
        public readonly array $references,
    ) {
    }

    public function getValue(): mixed
    {
        return $this->references;
    }
}
