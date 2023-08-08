<?php

declare(strict_types=1);

namespace App\Application\Serie\Query;

use App\Domain\Serie\Repository\SerieRepositoryInterface;

final class AllSeriesQueryHandler
{
    public function __construct(
        private SerieRepositoryInterface $serieRepository,
    ) {
    }

    public function __invoke(AllSeriesQuery $query): array
    {
        return $this->serieRepository->findAllSerieHeaders();
    }
}
