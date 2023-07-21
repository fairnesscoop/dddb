<?php

declare(strict_types=1);

namespace App\Application\Model\Command;

use App\Application\CommandInterface;
use App\Domain\Model\Model;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateCodeTacCommand implements CommandInterface
{
    public function __construct(
        public readonly Model $model,
        #[Assert\NotBlank()]
        #[Assert\Regex('/\d{8}/')]
        public ?string $codeTac = null,
    ) {
    }
}
