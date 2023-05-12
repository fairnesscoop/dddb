<?php

declare(strict_types=1);

namespace App\Application\Serie\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Manufacturer;

final class CreateSerieCommand implements CommandInterface
{
    public function __construct(
        public ?string $name = null,
        public ?Manufacturer $manufacturer = null,
    ) {
    }
}
