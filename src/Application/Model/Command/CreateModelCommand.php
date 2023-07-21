<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;
use App\Domain\Model\Serie;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateModelCommand implements CommandInterface
{
    public function __construct(
        public ?Serie $serie = null,
        #[Assert\NotBlank()]
        public ?string $codeName = null,
        public ?Model $parentModel = null,
    ) {
    }
}
