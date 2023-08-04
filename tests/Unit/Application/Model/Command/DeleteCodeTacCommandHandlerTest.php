<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Model\Command;

use App\Application\Model\Command\DeleteCodeTacCommand;
use App\Application\Model\Command\DeleteCodeTacCommandHandler;
use App\Domain\ModelEntity\Repository\CodeTacRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class DeleteCodeTacCommandHandlerTest extends TestCase
{
    private MockObject|CodeTacRepositoryInterface $codeTacRepository;
    private DeleteCodeTacCommandHandler $handler;

    public function setUp(): void
    {
        $this->codeTacRepository = $this->createMock(CodeTacRepositoryInterface::class);

        $this->handler = new DeleteCodeTacCommandHandler(
            $this->codeTacRepository,
        );
    }

    public function testRemoveCodeTac(): void
    {
        $codeTac = 12345678;

        $this->codeTacRepository
            ->expects(self::once())
            ->method('remove')
            ->with($codeTac);


        $command = new DeleteCodeTacCommand('12345678');

        ($this->handler)($command);
    }
}
