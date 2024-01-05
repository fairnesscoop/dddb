<?php

declare(strict_types=1);

namespace App\Application\Model\Query;

use App\Application\Model\View\ModelHeader;
use App\Domain\Model\Repository\ModelRepositoryInterface;
use App\Domain\Model\Repository\SearchRepositoryInterface;

final class SearchQueryHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
        private SearchRepositoryInterface $searchRepository,
    ) {
    }

    /** @return ModelHeader[] */
    public function __invoke(SearchQuery $searchQuery): iterable
    {
        if (ctype_digit($searchQuery->search) && \strlen($searchQuery->search) >= 8) {
            $model = $this->modelRepository->findModelByCodeTac(substr($searchQuery->search, 0, 8));

            return \is_null($model) ? [] : [$model];
        }

        return $this->searchRepository->search($searchQuery->search);
    }
}
