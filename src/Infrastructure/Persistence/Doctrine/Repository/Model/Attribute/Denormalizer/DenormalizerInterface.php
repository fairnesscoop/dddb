<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Denormalizer;

use App\Domain\Model\Attribute\AttributeInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface DenormalizerInterface
{
    public function createAttribute(mixed $value): AttributeInterface;

    public static function supports(): string;
}
