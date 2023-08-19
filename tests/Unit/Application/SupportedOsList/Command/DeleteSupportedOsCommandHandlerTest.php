<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\SupportedOsList\Command;

use App\Application\SupportedOsList\Command\DeleteSupportedOsCommand;
use App\Application\SupportedOsList\Command\DeleteSupportedOsCommandHandler;
use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\SupportedOs;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Os\OsVersionList;
use App\Tests\Factory\ModelFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class DeleteSupportedOsCommandHandlerTest extends TestCase
{
    private MockObject|AttributeRepositoryInterface $attributeRepository;
    private DeleteSupportedOsCommandHandler $handler;

    public function setUp(): void
    {
        $this->attributeRepository = $this->createMock(AttributeRepositoryInterface::class);

        $this->handler = new DeleteSupportedOsCommandHandler(
            $this->attributeRepository,
        );
    }

    public function testDeleteSupportedOs(): void
    {
        $osVersion1 = (new OsVersionList())->getById(1);
        $supportedOs1 = new SupportedOs(1, $osVersion1, 'http://example.com/doc1', null);
        $osVersion2 = (new OsVersionList())->getById(2);
        $supportedOs2 = new SupportedOs(2, $osVersion2, 'http://example.com/doc2', null);

        $model = ModelFactory::create();

        $existingAttributes = new AttributeCollection([
            SupportedOsList::NAME => new SupportedOsList([$supportedOs1, $supportedOs2]),
        ]);

        $this->attributeRepository->expects(self::once())
            ->method('getModelAttributes')
            ->with($model)
            ->willReturn($existingAttributes);

        $this->attributeRepository
            ->expects(self::once())
            ->method('updateModelAttribute')
            ->with($model, SupportedOsList::NAME, new SupportedOsList([$supportedOs1]));


        $command = new DeleteSupportedOsCommand($model, 2);

        ($this->handler)($command);
    }

    public function testSupportedOsNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $model = ModelFactory::create();

        $this->attributeRepository->expects(self::never())->method('updateModelAttribute');

        $command = new DeleteSupportedOsCommand($model, null);
        ($this->handler)($command);
    }
}
