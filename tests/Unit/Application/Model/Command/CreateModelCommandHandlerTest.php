<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Model\Command;

use App\Application\IdFactoryInterface;
use App\Application\Model\Command\CreateModelCommand;
use App\Application\Model\Command\CreateModelCommandHandler;
use App\Domain\Model\Manufacturer;
use App\Domain\Model\Model;
use App\Domain\Model\Serie;
use App\Domain\Model\Exception\CodeNameAlreadyExistsException;
use App\Domain\Model\Repository\ModelRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateModelCommandHandlerTest extends TestCase
{
    private MockObject|IdFactoryInterface $idFactory;
    private MockObject|ModelRepositoryInterface $modelRepository;
    private CreateModelCommandHandler $handler;

    public function setUp(): void
    {
        $this->idFactory = $this->createMock(IdFactoryInterface::class);
        $this->modelRepository = $this->createMock(ModelRepositoryInterface::class);

        $this->handler = new CreateModelCommandHandler(
            $this->modelRepository,
            $this->idFactory,
        );
    }

    public function testCreateModel(): void
    {
        $uuid = '91a43c84-aaf0-45b1-ba74-912960bda1c6';
        $codeName = 'G960F';
        $manufacturer = $this->createMock(Manufacturer::class);
        $serie = new Serie('6b8f5f4a-9be2-48d0-b35a-ac7109a9e2ff', 'Fairphone 3', $manufacturer);

        $this->idFactory
            ->expects(self::once())
            ->method('make')
            ->willReturn($uuid);

        $this->modelRepository
            ->expects(self::once())
            ->method('isCodeNameUsed')
            ->with($manufacturer, $codeName)
            ->willReturn(false);
        $model = new Model($uuid, $codeName, [], $serie);
        $this->modelRepository
            ->expects(self::once())
            ->method('add')
            ->with($model)
            ->willReturn($model);


        $command = new CreateModelCommand($serie, $codeName, null);

        $result = ($this->handler)($command);
        $this->assertEquals($model, $result);
    }

    public function testAlreadyExists(): void
    {
        $this->expectException(CodeNameAlreadyExistsException::class);

        $codeName = 'G961F';
        $manufacturer = $this->createMock(Manufacturer::class);
        $serie = new Serie('6b8f5f4a-9be2-48d0-b35a-ac7109a9e2ff', 'Fairphone 3', $manufacturer);

        $this->idFactory
            ->expects(self::never())
            ->method('make');

        $this->modelRepository
            ->expects(self::once())
            ->method('isCodeNameUsed')
            ->with($manufacturer, $codeName)
            ->willReturn(true);
        $this->modelRepository
            ->expects(self::never())
            ->method('add');

        $command = new CreateModelCommand($serie, $codeName, null);

        ($this->handler)($command);
    }
}
