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
        public ?string $reference = null,
        #[Assert\NotBlank()]
        public ?string $androidCodeName = null,
        public ?int $variant = 0,
        public ?Model $parentModel = null,
    ) {
    }
}
