<?php

declare(strict_types=1);

namespace App\Application\SupportedOsList\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;
use App\Domain\Os\Version as OsVersion;

class AddSupportedOsCommand implements CommandInterface
{
    public function __construct(
        public readonly Model $model,
        public ?OsVersion $osVersion = null,
        public ?string $helpLink = null,
        public ?string $comment = null,
        public ?string $recoveryFileUrl = null,
        public ?string $romFileUrl = null,
    ) {
    }
}
