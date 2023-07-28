<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface BuilderInterface
{
    public function createAttribute(mixed $value): AttributeInterface;

    public static function supports(): string;
}
