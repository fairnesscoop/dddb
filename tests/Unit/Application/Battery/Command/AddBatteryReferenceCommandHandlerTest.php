<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Battery\Command;

use App\Application\Battery\Command\AddBatteryReferenceCommand;
use App\Application\Battery\Command\AddBatteryReferenceCommandHandler;
use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\Battery;
use App\Tests\Factory\ModelFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class AddBatteryReferenceCommandHandlerTest extends TestCase
{
    private MockObject&AttributeRepositoryInterface $attributeRepository;
    private AddBatteryReferenceCommandHandler $handler;

    public function setUp(): void
    {
        $this->attributeRepository = $this->createMock(AttributeRepositoryInterface::class);

        $this->handler = new AddBatteryReferenceCommandHandler(
            $this->attributeRepository,
        );
    }

    public function testAddBatteryNewReference(): void
    {
        $reference = 'F4BATT-NEW';

        $model = ModelFactory::create(attributes: [Battery::NAME => ['F4BATT-EXISTING']]);

        $existingAttributes = new AttributeCollection([Battery::NAME => new Battery($model->getAttributes()[Battery::NAME])]);
        $expectedAttribute = new Battery(['F4BATT-EXISTING', 'F4BATT-NEW']);
        $this->attributeRepository->expects(self::once())
            ->method('getModelAttributes')
            ->with($model)
            ->willReturn($existingAttributes);

        $this->attributeRepository
            ->expects(self::once())
            ->method('updateModelAttribute')
            ->with($model, Battery::NAME, $expectedAttribute);


        $command = new AddBatteryReferenceCommand($model, $reference);

        ($this->handler)($command);
    }

    public function testAddBatteryNewReferenceOnEmptyAttribute(): void
    {
        $reference = 'F4BATT-NEW';

        $model = ModelFactory::create(attributes: []);

        $existingAttributes = new AttributeCollection([]);
        $expectedAttribute = new Battery(['F4BATT-NEW']);
        $this->attributeRepository->expects(self::once())
            ->method('getModelAttributes')
            ->with($model)
            ->willReturn($existingAttributes);

        $this->attributeRepository
            ->expects(self::once())
            ->method('updateModelAttribute')
            ->with($model, Battery::NAME, $expectedAttribute);


        $command = new AddBatteryReferenceCommand($model, $reference);

        ($this->handler)($command);
    }

    #[DataProvider('emptyValues')]
    public function testAddBatteryEmptyReference(mixed $emptyValue): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $model = ModelFactory::create();

        $this->attributeRepository->expects(self::never())->method('updateModelAttribute');


        $command = new AddBatteryReferenceCommand($model, $emptyValue);

        ($this->handler)($command);
    }

    public static function emptyValues(): array
    {
        return [[null], ['']];
    }
}
