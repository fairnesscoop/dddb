<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EOsModel
{
    public string $vendor;
    #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
    public string $name;
    /** @internal use getModels() method */
    public array|string $models = [];
    public string $codename;
    #[SerializedName('build_version_dev')]
    public string $buildVersionDev;
    #[SerializedName('build_version_stable')]
    public ?string $buildVersionStable = null;

    #[Ignore()]
    public function getModels(): array
    {
        return \is_string($this->models) ? [$this->models] : $this->models;
    }
}
