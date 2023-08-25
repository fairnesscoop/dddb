<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

class DerivedAttribute implements AttributeInterface
{
    public function __construct(
        private readonly AttributeInterface $baseAttribute,
    ) {
    }

    public function getValue(): mixed
    {
        return $this->baseAttribute->getValue();
    }

    public function isDerived(): bool
    {
        return true;
    }
}
