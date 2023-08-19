<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Model\Query;

use App\Application\Attribute\Builder\AttributeGenericBuilder;
use App\Application\Model\Query\ModelQuery;
use App\Application\Model\Query\ModelQueryHandler;
use App\Application\Model\View\ModelView;
use App\Domain\Model\Repository\CodeTacRepositoryInterface;
use App\Domain\Model\Repository\ModelRepositoryInterface;
use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Exception\ModelNotFoundException;
use App\Tests\Factory\ModelFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ModelQueryHandlerTest extends TestCase
{
    private MockObject|ModelRepositoryInterface $modelRepository;
    private MockObject|AttributeRepositoryInterface $attributeRepository;
    private MockObject|CodeTacRepositoryInterface $codeTacRepository;
    private ModelQueryHandler $handler;

    public function setUp(): void
    {
        $this->modelRepository = $this->createMock(ModelRepositoryInterface::class);
        $this->attributeRepository = $this->createMock(AttributeRepositoryInterface::class);
        $this->codeTacRepository = $this->createMock(CodeTacRepositoryInterface::class);
        $this->handler = new ModelQueryHandler(
            $this->modelRepository,
            $this->attributeRepository,
            $this->codeTacRepository,
        );
    }

    public function testGetModelView(): void
    {
        $model = ModelFactory::create();
        $attributes = new AttributeCollection([Battery::NAME => new Battery($model->getAttributes()[Battery::NAME])]);

        $this->modelRepository
            ->expects(self::once())
            ->method('findModelByUuid')
            ->with(ModelFactory::MODEL_UUID)
            ->willReturn($model);
        $this->attributeRepository
            ->method('getModelAttributes')
            ->with($model)
            ->willReturn($attributes);
        $this->codeTacRepository
            ->expects(self::once())
            ->method('findCodeTacs')
            ->with($model)
            ->willReturn(['12345678']);

        $expectedView = new ModelView(ModelFactory::MODEL_UUID, $model->getCodeName(), $attributes, ['12345678']);

        $query = new ModelQuery(ModelFactory::MODEL_UUID);
        $result = ($this->handler)($query);

        $this->assertEquals($expectedView, $result);
    }

    public function testModelNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->modelRepository
            ->expects(self::once())
            ->method('findModelByUuid')
            ->with(ModelFactory::MODEL_UUID)
            ->willReturn(null);

        $query = new ModelQuery(ModelFactory::MODEL_UUID);
        ($this->handler)($query);
    }
}
