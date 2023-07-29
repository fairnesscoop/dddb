<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Model\Command;

use App\Application\Model\Command\CreateCodeTacCommand;
use App\Application\Model\Command\CreateCodeTacCommandHandler;
use App\Domain\Model\CodeTac;
use App\Domain\ModelEntity\Repository\CodeTacRepositoryInterface;
use App\Domain\Model\Model;
use App\Domain\ModelEntity\Exception\CodeTacAlreadyExistsException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateCodeTacCommandHandlerTest extends TestCase
{
    private MockObject|CodeTacRepositoryInterface $codeTacRepository;
    private CreateCodeTacCommandHandler $handler;

    public function setUp(): void
    {
        $this->codeTacRepository = $this->createMock(CodeTacRepositoryInterface::class);

        $this->handler = new CreateCodeTacCommandHandler(
            $this->codeTacRepository,
        );
    }

    public function testCreateCodeTac(): void
    {
        $codeTac = 12345678;
        $model = $this->createMock(Model::class);

        $this->codeTacRepository
            ->expects(self::once())
            ->method('isCodeTacUsed')
            ->with($codeTac)
            ->willReturn(false);

        $codeTacEntity = new CodeTac($codeTac, $model);

        $this->codeTacRepository
            ->expects(self::once())
            ->method('add')
            ->with($codeTacEntity)
            ->willReturn($codeTacEntity);


        $command = new CreateCodeTacCommand($model, '12345678');

        $result = ($this->handler)($command);
        $this->assertEquals($codeTacEntity, $result);
    }

    public function testAlreadyExists(): void
    {
        $this->expectException(CodeTacAlreadyExistsException::class);

        $codeTac = 33445566;
        $model = $this->createMock(Model::class);

        $this->codeTacRepository
            ->expects(self::once())
            ->method('isCodeTacUsed')
            ->with($codeTac)
            ->willReturn(true);

        $this->codeTacRepository->expects(self::never())->method('add');


        $command = new CreateCodeTacCommand($model, '33445566');

        ($this->handler)($command);
    }
}
