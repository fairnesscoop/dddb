<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

class AttributeCollection extends \ArrayIterator
{
    public function has(string $name): bool
    {
        return $this->offsetExists($name);
    }

    public function get(string $name): AttributeInterface
    {
        return $this->offsetGet($name);
    }

    public function set(string $name, AttributeInterface $attribute): void
    {
        $this->offsetSet($name, $attribute);
    }
}
