<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Serie\Query;

use App\Application\Serie\Query\ListSeriesQuery;
use App\Application\Serie\Query\ListSeriesQueryHandler;
use App\Domain\Model\Serie;
use App\Domain\Pagination;
use App\Domain\Serie\Repository\SerieRepositoryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ListSeriesQueryHandlerTest extends TestCase
{
    private MockObject&SerieRepositoryInterface $serieRepository;

    public function setUp(): void
    {
        $this->serieRepository = $this->createMock(SerieRepositoryInterface::class);
    }

    public function testList(): void
    {
        /** @var MockObject&Paginator<Serie> $paginator */
        $paginator = $this->createMock(Paginator::class);
        $paginator->expects(self::once())->method('count')->willReturn(1);

        $this->serieRepository
            ->expects(self::once())
            ->method('findPaginatedSeries')
            ->with(1, 20)
            ->willReturn($paginator);

        $handler = new ListSeriesQueryHandler(
            $this->serieRepository
        );

        $query = new ListSeriesQuery(
            page: 1,
            pageSize: 20,
            manufacturerUuid: null,
        );

        $result = $handler($query);

        $this->assertInstanceOf(Pagination::class, $result);
        $this->assertIsIterable($result->items);
        self::assertEquals(1, $result->totalItems);
        self::assertEquals([1], $result->windowPages);
    }
}
