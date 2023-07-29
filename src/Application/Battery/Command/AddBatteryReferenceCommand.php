<?php

declare(strict_types=1);

namespace App\Application\Battery\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;

class AddBatteryReferenceCommand implements CommandInterface
{
    public function __construct(
        public readonly Model $model,
        public string|null $batteryReference = null,
    ) {
    }
}
