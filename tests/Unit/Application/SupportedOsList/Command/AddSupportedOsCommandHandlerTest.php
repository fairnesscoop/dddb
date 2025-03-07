<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\SupportedOsList\Command;

use App\Application\SupportedOsList\Command\AddSupportedOsCommand;
use App\Application\SupportedOsList\Command\AddSupportedOsCommandHandler;
use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\SupportedOs;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Os\OsVersionList;
use App\Tests\Factory\ModelFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class AddSupportedOsCommandHandlerTest extends TestCase
{
    private MockObject&AttributeRepositoryInterface $attributeRepository;
    private AddSupportedOsCommandHandler $handler;

    public function setUp(): void
    {
        $this->attributeRepository = $this->createMock(AttributeRepositoryInterface::class);

        $this->handler = new AddSupportedOsCommandHandler(
            $this->attributeRepository,
        );
    }

    public function testAddNewSupportedOs(): void
    {
        $existingOsVersion = (new OsVersionList())->getById(1);

        $model = ModelFactory::create(attributes: [$existingOsVersion = (new OsVersionList())->getById(2)]);
        $existingSupportedOs = new SupportedOs(2, $existingOsVersion, 'http://example.com/doc', null);

        $existingAttributes = new AttributeCollection([
            SupportedOsList::NAME => new SupportedOsList([$existingSupportedOs]),
        ]);

        $newOsVersion = (new OsVersionList())->getById(2);
        $newSupportedOs = new SupportedOs(3, $newOsVersion, 'http://example.com/doc2', 'Comment...');
        $expectedAttribute = new SupportedOsList([$existingSupportedOs, $newSupportedOs]);
        $this->attributeRepository->expects(self::once())
            ->method('getModelAttributes')
            ->with($model)
            ->willReturn($existingAttributes);

        $this->attributeRepository
            ->expects(self::once())
            ->method('updateModelAttribute')
            ->with($model, SupportedOsList::NAME, $expectedAttribute);


        $command = new AddSupportedOsCommand($model, $newOsVersion, 'http://example.com/doc2', 'Comment...');

        ($this->handler)($command);
    }

    public function testAddNewSupportedOsOnEmptyAttribute(): void
    {
        $newOsVersion = (new OsVersionList())->getById(2);

        $model = ModelFactory::create(attributes: []);

        $existingAttributes = new AttributeCollection([]);
        $newOsVersion = (new OsVersionList())->getById(2);
        $newSupportedOs = new SupportedOs(1, $newOsVersion, 'http://example.com/doc2', 'Comment...');
        $expectedAttribute = new SupportedOsList([$newSupportedOs]);
        $this->attributeRepository->expects(self::once())
            ->method('getModelAttributes')
            ->with($model)
            ->willReturn($existingAttributes);

        $this->attributeRepository
            ->expects(self::once())
            ->method('updateModelAttribute')
            ->with($model, SupportedOsList::NAME, $expectedAttribute);


        $command = new AddSupportedOsCommand($model, $newOsVersion, 'http://example.com/doc2', 'Comment...');

        ($this->handler)($command);
    }

    public function testAddEmptyOsVersion(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $model = ModelFactory::create();

        $this->attributeRepository->expects(self::never())->method('updateModelAttribute');


        $command = new AddSupportedOsCommand($model, null);

        ($this->handler)($command);
    }
}
