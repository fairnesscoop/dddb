<?php

declare(strict_types=1);

namespace App\Application\Manufacturer\Command;

use App\Application\CommandInterface;

final class CreateManufacturerCommand implements CommandInterface
{
    public function __construct(
        public ?string $name = null,
    ) {
    }
}
