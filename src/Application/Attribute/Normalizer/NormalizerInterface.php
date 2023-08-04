<?php

declare(strict_types=1);

namespace App\Application\Attribute\Normalizer;

use App\Domain\Model\Attribute\AttributeInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag()]
interface NormalizerInterface
{
    public function normalize(AttributeInterface $attribute): array|string;

    public static function supports(): string;
}
