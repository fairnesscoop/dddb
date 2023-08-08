<?php

declare(strict_types=1);

namespace App\Application\Model\Query;

use App\Application\Model\View\ModelHeader;
use App\Domain\ModelEntity\Repository\ModelRepositoryInterface;

final class ListSerieModelsQueryHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
    ) {
    }

    /** @return ModelHeader[] */
    public function __invoke(ListSerieModelsQuery $listSerieModelsQuery): iterable
    {
        return $this->modelRepository->findAllModelHeaders($listSerieModelsQuery->serie);
    }
}
