<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Manufacturer\Query;

use App\Application\Manufacturer\Query\ListManufacturersQuery;
use App\Application\Manufacturer\Query\ListManufacturersQueryHandler;
use App\Domain\Manufacturer\Repository\ManufacturerRepositoryInterface;
use App\Domain\Pagination;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ListManufacturersQueryHandlerTest extends TestCase
{
    private MockObject|ManufacturerRepositoryInterface $manufacturerRepository;

    public function setUp(): void
    {
        $this->manufacturerRepository = $this->createMock(ManufacturerRepositoryInterface::class);
    }

    public function testList(): void
    {
        /** @var MockObject|Paginator $paginator */
        $paginator = $this->createMock(Paginator::class);
        $paginator->expects(self::once())->method('count')->willReturn(1);

        $this->manufacturerRepository
            ->expects(self::once())
            ->method('findManufacturers')
            ->willReturn($paginator);

        $handler = new ListManufacturersQueryHandler(
            $this->manufacturerRepository
        );

        $query = new ListManufacturersQuery(
            page: 1,
            pageSize: 20
        );

        $result = $handler($query);

        $this->assertInstanceOf(Pagination::class, $result);
        $this->assertIsIterable($result->items);
        self::assertEquals(1, $result->totalItems);
        self::assertEquals([1], $result->windowPages);
    }
}
