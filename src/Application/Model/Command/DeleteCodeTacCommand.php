<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\CommandInterface;

final class DeleteCodeTacCommand implements CommandInterface
{
    public function __construct(
        public readonly string $codeTac,
    ) {
    }
}
