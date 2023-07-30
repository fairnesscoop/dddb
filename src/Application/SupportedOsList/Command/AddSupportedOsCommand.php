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
        public OsVersion|null $osVersion = null,
        public string|null $helpLink = null,
        public string|null $comment = null,
    ) {
    }
}
