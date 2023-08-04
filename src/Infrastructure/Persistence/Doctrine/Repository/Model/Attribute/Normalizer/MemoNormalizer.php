<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Domain\Model\Attribute\Memo;

class MemoNormalizer extends BaseNormalizer
{
    public static function supports(): string
    {
        return Memo::NAME;
    }
}
