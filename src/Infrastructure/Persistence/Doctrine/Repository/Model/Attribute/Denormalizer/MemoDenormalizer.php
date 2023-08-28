<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Denormalizer;

use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\Memo;

class MemoDenormalizer implements DenormalizerInterface
{
    public function createAttribute(mixed $value): AttributeInterface
    {
        return new Memo($value);
    }

    public static function supports(): string
    {
        return Memo::NAME;
    }
}
