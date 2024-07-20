<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Manufacturer\Command;

use App\Application\IdFactoryInterface;
use App\Application\Manufacturer\Command\CreateManufacturerCommand;
use App\Application\Manufacturer\Command\CreateManufacturerCommandHandler;
use App\Domain\Manufacturer\Exception\NameAlreadyExistsException;
use App\Domain\Model\Manufacturer;
use App\Domain\Manufacturer\Repository\ManufacturerRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateManufacturerCommandHandlerTest extends TestCase
{
    private MockObject|IdFactoryInterface $idFactory;
    private MockObject|ManufacturerRepositoryInterface $manufacturerRepository;

    public function setUp(): void
    {
        $this->idFactory = $this->createMock(IdFactoryInterface::class);
        $this->manufacturerRepository = $this->createMock(ManufacturerRepositoryInterface::class);
    }

    public function testCreateManufacturer(): void
    {
        $uuid = 'bf33cc50-94f4-474a-bd43-0be12bba5877';
        $name = 'Fairphone';

        $this->idFactory
            ->expects(self::once())
            ->method('make')
            ->willReturn($uuid);

        $this->manufacturerRepository
            ->expects(self::once())
            ->method('isNameUsed')
            ->with($name)
            ->willReturn(false);
        $manufacturer = new Manufacturer($uuid, $name);
        $this->manufacturerRepository
            ->expects(self::once())
            ->method('add')
            ->with($manufacturer)
            ->willReturn($manufacturer);

        $handler = new CreateManufacturerCommandHandler(
            $this->manufacturerRepository,
            $this->idFactory,
        );

        $command = new CreateManufacturerCommand($name);

        $result = $handler($command);
        self::assertEquals($manufacturer, $result);
    }

    public function testAlreadyExists(): void
    {
        $this->expectException(NameAlreadyExistsException::class);

        $name = 'Fairphone';

        $this->idFactory
            ->expects(self::never())
            ->method('make');

        $this->manufacturerRepository
            ->expects(self::once())
            ->method('isNameUsed')
            ->with($name)
            ->willReturn(true);
        $this->manufacturerRepository
            ->expects(self::never())
            ->method('add');

        $handler = new CreateManufacturerCommandHandler(
            $this->manufacturerRepository,
            $this->idFactory,
        );

        $command = new CreateManufacturerCommand($name);

        $handler($command);
    }
}
