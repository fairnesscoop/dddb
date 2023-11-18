<?php

declare(strict_types=1);

namespace App\Application\Serie\Query;

use App\Domain\Pagination;
use App\Domain\Serie\Repository\SerieRepositoryInterface;

final class ListSeriesQueryHandler
{
    public function __construct(
        private SerieRepositoryInterface $serieRepository,
    ) {
    }

    public function __invoke(ListSeriesQuery $listSeriesQuery): Pagination
    {
        $page = $listSeriesQuery->page;
        $pageSize = $listSeriesQuery->pageSize;

        $result = $this->serieRepository->findPaginatedSeries(
            page: $page,
            pageSize: $pageSize,
            manufacturerUuid: $listSeriesQuery->manufacturerUuid,
        );

        return new Pagination(
            items: $result,
            totalItems: $result->count(),
            page: $page,
            pageSize: $pageSize,
        );
    }
}
