<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Battery\Command;

use App\Application\Battery\Command\AddBatteryReferenceCommand;
use App\Application\Battery\Command\AddBatteryReferenceCommandHandler;
use App\Domain\ModelEntity\Repository\ModelRepositoryInterface;
use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Attribute\Builder\AttributeGenericBuilder;
use App\Domain\Model\Attribute\Builder\AttributeNormalizer;
use App\Tests\Factory\ModelFactory;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class AddBatteryReferenceCommandHandlerTest extends TestCase
{
    private MockObject|ModelRepositoryInterface $modelRepository;
    private MockObject|AttributeGenericBuilder $attributeGenericBuilder;
    private MockObject|AttributeNormalizer $attributeNormalizer;
    private AddBatteryReferenceCommandHandler $handler;

    public function setUp(): void
    {
        $this->modelRepository = $this->createMock(ModelRepositoryInterface::class);
        $this->attributeGenericBuilder = $this->createMock(AttributeGenericBuilder::class);
        $this->attributeNormalizer = $this->createMock(AttributeNormalizer::class);

        $this->handler = new AddBatteryReferenceCommandHandler(
            $this->modelRepository,
            $this->attributeGenericBuilder,
            $this->attributeNormalizer,
        );
    }

    public function testAddBatteryNewReference(): void
    {
        $reference = 'F4BATT-NEW';

        $model = ModelFactory::create(attributes: [Battery::NAME => ['F4BATT-EXISTING']]);

        $existingAttributes = new AttributeCollection([Battery::NAME => new Battery($model->getAttributes()[Battery::NAME])]);
        $expectedAttributes = new AttributeCollection([Battery::NAME => new Battery(['F4BATT-EXISTING', 'F4BATT-NEW'])]);
        $this->attributeGenericBuilder->expects(self::once())
            ->method('createAttributeCollection')
            ->with($model->getAttributes())
            ->willReturn($existingAttributes);
        $this->attributeNormalizer->expects(self::once())
            ->method('normalize')
            ->with($expectedAttributes)
            ->willReturn([Battery::NAME => ['F4BATT-EXISTING', 'F4BATT-NEW']]);

        $this->modelRepository
            ->expects(self::once())
            ->method('update')
            ->with($model)
            ->willReturn($model);


        $command = new AddBatteryReferenceCommand($model, $reference);

        $result = ($this->handler)($command);
        $this->assertCount($existingAttributes->count() + 1, $result->getAttributes()[Battery::NAME]);
        $this->assertContains('F4BATT-EXISTING', $result->getAttributes()[Battery::NAME]);
        $this->assertContains('F4BATT-NEW', $result->getAttributes()[Battery::NAME]);
    }

    public function testAddBatteryNewReferenceOnEmptyAttribute(): void
    {
        $reference = 'F4BATT-NEW';

        $model = ModelFactory::create(attributes: []);

        $existingAttributes = new AttributeCollection([]);
        $expectedAttributes = new AttributeCollection([Battery::NAME => new Battery(['F4BATT-NEW'])]);
        $this->attributeGenericBuilder->expects(self::once())
            ->method('createAttributeCollection')
            ->with($model->getAttributes())
            ->willReturn($existingAttributes);
        $this->attributeNormalizer->expects(self::once())
            ->method('normalize')
            ->with($expectedAttributes)
            ->willReturn([Battery::NAME => ['F4BATT-NEW']]);

        $this->modelRepository
            ->expects(self::once())
            ->method('update')
            ->with($model)
            ->willReturn($model);


        $command = new AddBatteryReferenceCommand($model, $reference);

        $result = ($this->handler)($command);
        $this->assertCount(1, $result->getAttributes()[Battery::NAME]);
        $this->assertContains('F4BATT-NEW', $result->getAttributes()[Battery::NAME]);
    }

    #[DataProvider('emptyValues')]
    public function testAddBatteryEmptyReference(mixed $emptyValue): void
    {
        $this->expectException(InvalidArgumentException::class);

        $model = ModelFactory::create();

        $this->modelRepository->expects(self::never())->method('update');


        $command = new AddBatteryReferenceCommand($model, $emptyValue);

        ($this->handler)($command);
    }

    public static function emptyValues(): array
    {
        return [[null], ['']];
    }
}
