<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Application\Attribute\Normalizer\NormalizerInterface;
use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\SupportedOs;
use App\Domain\Model\Attribute\SupportedOsList;

class SupportedOsListNormalizer implements NormalizerInterface
{
    public function normalize(AttributeInterface $attribute): array
    {
        return array_map(
            static fn (SupportedOs $supportedOs) => [
                'id' => $supportedOs->id,
                'osVersionId' => $supportedOs->osVersion->getId(),
                'helpLink' => $supportedOs->helpLink,
                'comment' => $supportedOs->comment,
                'recoveryFileUrl' => $supportedOs->recoveryFileUrl,
                'romFileUrl' => $supportedOs->romFileUrl,
            ],
            $attribute->getValue(),
        );
    }

    public static function supports(): string
    {
        return SupportedOsList::NAME;
    }
}
