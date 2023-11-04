<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class LineageModel
{
    public string $vendor;
    public string $name;
    public array $models = [];
    // android codename, not codename used in model of domain
    #[SerializedName('codename')]
    public string $androidCode;
    #[SerializedName('current_branch')]
    #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
    public string $currentBranch;
}
