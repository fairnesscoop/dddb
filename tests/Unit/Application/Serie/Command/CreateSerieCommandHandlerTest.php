<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Serie\Command;

use App\Application\IdFactoryInterface;
use App\Application\Serie\Command\CreateSerieCommand;
use App\Application\Serie\Command\CreateSerieCommandHandler;
use App\Domain\Model\Manufacturer;
use App\Domain\Model\Serie;
use App\Domain\Serie\Exception\NameAlreadyExistsException;
use App\Domain\Serie\Repository\SerieRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateSerieCommandHandlerTest extends TestCase
{
    private MockObject&IdFactoryInterface $idFactory;
    private MockObject&SerieRepositoryInterface $serieRepository;

    public function setUp(): void
    {
        $this->idFactory = $this->createMock(IdFactoryInterface::class);
        $this->serieRepository = $this->createMock(SerieRepositoryInterface::class);
    }

    public function testCreateSerie(): void
    {
        $uuid = '22a6ef6c-f4c2-4228-9348-50edf1f43a98';
        $name = '4';
        $manufacturer = $this->createManufacturer();

        $this->idFactory
            ->expects(self::once())
            ->method('make')
            ->willReturn($uuid);

        $this->serieRepository
            ->expects(self::once())
            ->method('isNameUsed')
            ->with($manufacturer, $name)
            ->willReturn(false);
        $serie = new Serie($uuid, $name, $manufacturer);
        $this->serieRepository
            ->expects(self::once())
            ->method('add')
            ->with($serie)
            ->willReturn($serie);

        $handler = new CreateSerieCommandHandler(
            $this->serieRepository,
            $this->idFactory,
        );

        $command = new CreateSerieCommand($name, $manufacturer);

        $result = $handler($command);
        self::assertEquals($serie, $result);
    }

    public function testAlreadyExists(): void
    {
        $this->expectException(NameAlreadyExistsException::class);

        $name = 'Fairphone';

        $this->idFactory
            ->expects(self::never())
            ->method('make');

        $this->serieRepository
            ->expects(self::once())
            ->method('isNameUsed')
            ->willReturn(true);
        $this->serieRepository
            ->expects(self::never())
            ->method('add');

        $handler = new CreateSerieCommandHandler(
            $this->serieRepository,
            $this->idFactory,
        );

        $command = new CreateSerieCommand($name, $this->createManufacturer());

        $handler($command);
    }

    private function createManufacturer(): Manufacturer
    {
        return new Manufacturer('085240f4-272a-4efe-bac8-c96c93b1379d', 'Fairphone');
    }
}
