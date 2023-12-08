<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Model\Query;

use App\Application\Model\Query\ListModelsQuery;
use App\Application\Model\Query\ListModelsQueryHandler;
use App\Domain\Model\Serie;
use App\Domain\Model\Repository\ModelRepositoryInterface;
use App\Domain\Pagination;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ListModelsQueryHandlerTest extends TestCase
{
    private MockObject|ModelRepositoryInterface $modelRepository;
    private ListModelsQueryHandler $handler;

    public function setUp(): void
    {
        $this->modelRepository = $this->createMock(ModelRepositoryInterface::class);
        $this->handler = new ListModelsQueryHandler(
            $this->modelRepository
        );
    }

    public function testList(): void
    {
        /** @var MockObject|Paginator $paginator */
        $paginator = $this->createMock(Paginator::class);
        $paginator->expects(self::once())->method('count')->willReturn(1);

        $serie = $this->createMock(Serie::class);

        $this->modelRepository
            ->expects(self::once())
            ->method('findPaginatedModels')
            ->with($serie, 1, 20)
            ->willReturn($paginator);

        $query = new ListModelsQuery(
            $serie,
            page: 1,
            pageSize: 20
        );

        $result = ($this->handler)($query);

        $this->assertInstanceOf(Pagination::class, $result);
        $this->assertIsIterable($result->items);
        $this->assertEquals(1, $result->totalItems);
        $this->assertEquals([1], $result->windowPages);
    }
}
