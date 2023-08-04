<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;

final class CreateCodeTacCommand implements CommandInterface
{
    public function __construct(
        public readonly Model $model,
        public ?string $codeTac = null,
    ) {
    }
}
