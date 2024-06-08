<?php

declare(strict_types=1);

namespace App\Application\SupportedOsList\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;

class DeleteSupportedOsCommand implements CommandInterface
{
    public function __construct(
        public readonly Model $model,
        public ?int $supportedOsId = null,
    ) {
    }
}
