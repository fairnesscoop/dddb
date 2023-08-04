<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Memo\Command;

use App\Application\Attribute\Builder\AttributeGenericBuilder;
use App\Application\Memo\Command\SetMemoCommand;
use App\Application\Memo\Command\SetMemoCommandHandler;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\Memo;
use App\Tests\Factory\ModelFactory;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SetMemoCommandHandlerTest extends TestCase
{
    private MockObject|AttributeGenericBuilder $attributeRepository;
    private SetMemoCommandHandler $handler;

    public function setUp(): void
    {
        $this->attributeRepository = $this->createMock(AttributeRepositoryInterface::class);

        $this->handler = new SetMemoCommandHandler(
            $this->attributeRepository,
        );
    }

    public function testSetMemo(): void
    {
        $text = 'Prefered OS is /e/';

        $model = ModelFactory::create(attributes: [Memo::NAME => '...']);

        $expectedAttribute = new Memo($text);
        $this->attributeRepository
            ->expects(self::once())
            ->method('updateModelAttribute')
            ->with($model, Memo::NAME, $expectedAttribute);


        $command = new SetMemoCommand($model, $text);

        ($this->handler)($command);
    }

    public function testAddNewMemo(): void
    {
        $text = 'Prefered OS is /e/';

        $model = ModelFactory::create(attributes: []);

        $expectedAttribute = new Memo($text);
        $this->attributeRepository
            ->expects(self::once())
            ->method('updateModelAttribute')
            ->with($model, Memo::NAME, $expectedAttribute);


        $command = new SetMemoCommand($model, $text);

        ($this->handler)($command);
    }

    #[DataProvider('emptyValues')]
    public function testSetEmptyMemo(mixed $emptyValue): void
    {
        $this->expectException(InvalidArgumentException::class);

        $model = ModelFactory::create();

        $this->attributeRepository->expects(self::never())->method('updateModelAttribute');


        $command = new SetMemoCommand($model, $emptyValue);

        ($this->handler)($command);
    }

    public static function emptyValues(): array
    {
        return [[null], ['']];
    }
}
