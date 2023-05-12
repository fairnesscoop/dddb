<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;
use App\Domain\Model\Serie;

final class CreateModelCommand implements CommandInterface
{
    public function __construct(
        public ?Serie $serie = null,
        public ?string $codeName = null,
        public ?Model $parentModel = null,
    ) {
    }
}
