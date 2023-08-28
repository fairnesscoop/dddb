<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

class Memo extends BaseAttribute
{
    public const NAME = 'memo';

    public function __construct(
        private readonly string $text,
    ) {
    }

    public function getValue(): mixed
    {
        return $this->text;
    }
}
