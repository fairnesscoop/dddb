<?php

declare(strict_types=1);

namespace App\Application\Model\Query;

use App\Domain\ModelEntity\Repository\ModelRepositoryInterface;
use App\Domain\Pagination;

final class ListModelsQueryHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
    ) {
    }

    public function __invoke(ListModelsQuery $listModelsQuery): Pagination
    {
        $page = $listModelsQuery->page;
        $pageSize = $listModelsQuery->pageSize;

        $result = $this->modelRepository->findModels(
            serie: $listModelsQuery->serie,
            page: $page,
            pageSize: $pageSize,
        );

        return new Pagination(
            items: $result,
            totalItems: $result->count(),
            page: $page,
            pageSize: $pageSize,
        );
    }
}
