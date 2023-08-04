<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

class Memo implements AttributeInterface
{
    public const NAME = 'memo';

    public function __construct(
        public string $text,
    ) {
    }

    public function getValue(): mixed
    {
        return $this->text;
    }
}
