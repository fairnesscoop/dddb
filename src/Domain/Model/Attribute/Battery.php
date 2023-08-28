<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

class Battery extends BaseAttribute
{
    public const NAME = 'battery';

    public function __construct(
        private readonly array $references,
    ) {
    }

    public function getValue(): mixed
    {
        return $this->references;
    }
}
