<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

abstract class BaseAttribute implements AttributeInterface
{
    public function isDerived(): bool
    {
        return false;
    }
}
