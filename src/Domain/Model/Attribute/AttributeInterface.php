<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

interface AttributeInterface
{
    public function getValue(): mixed;
}
