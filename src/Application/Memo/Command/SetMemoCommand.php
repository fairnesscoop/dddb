<?php

declare(strict_types=1);

namespace App\Application\Memo\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;

class SetMemoCommand implements CommandInterface
{
    public function __construct(
        public readonly Model $model,
        public string|null $text = null,
    ) {
    }
}
