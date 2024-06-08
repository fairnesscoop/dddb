<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;

class SetAndroidCodeNameCommand implements CommandInterface
{
    public function __construct(
        public Model $model,
        public ?string $androidCodeName = null,
        public int $variant = 0,
    ) {
    }
}
