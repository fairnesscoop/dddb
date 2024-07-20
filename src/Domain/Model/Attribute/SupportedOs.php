<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

use App\Domain\Os\Version;

class SupportedOs
{
    public function __construct(
        public readonly int $id,
        public readonly Version $osVersion,
        public readonly ?string $helpLink,
        public readonly ?string $comment,
        public readonly ?string $recoveryIpfsCid = null,
        public readonly ?string $romIpfsCid = null,
    ) {
    }
}
