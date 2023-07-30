<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

use App\Domain\Os\Version;

class SupportedOs
{
    public function __construct(
        public readonly int $id,
        public readonly Version $osVersion,
        public readonly string|null $helpLink,
        public readonly string|null $comment,
    ) {
    }
}
