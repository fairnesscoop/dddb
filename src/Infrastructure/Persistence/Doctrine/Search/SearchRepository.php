<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Search;

use App\Application\Model\View\ModelHeader;
use App\Domain\Model\Repository\SearchRepositoryInterface;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;

class SearchRepository implements SearchRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly SearchIndexer $searchIndexer,
    ) {
    }

    public function search(string $query): iterable
    {
        $queryTerms = $this->searchIndexer->tokenize($query);

        $termQueryBuilder = $this->connection->createQueryBuilder();
        $termQueryBuilder->select(
            'term.model_uuid AS uuid',
            'model.reference',
            'model.android_code_name',
            'model.variant',
            'serie.name AS serie',
            'serie.uuid AS serie_uuid',
            'manufacturer.name AS manufacturer',
        )->from('term');

        $termQueryBuilder->join('term', 'model', 'model', 'model.uuid = term.model_uuid');
        $termQueryBuilder->join('model', 'serie', 'serie', 'serie.uuid = model.serie_uuid');
        $termQueryBuilder->join('serie', 'manufacturer', 'manufacturer', 'manufacturer.uuid = serie.manufacturer_uuid');

        $exactMatchClause = $termQueryBuilder->expr()->in('word', ':words');
        $termQueryBuilder->where($exactMatchClause);
        $termQueryBuilder->setParameter('words', $queryTerms, ArrayParameterType::STRING);

        foreach ($queryTerms as $index => $termValue) {
            $termQueryBuilder->orWhere($termQueryBuilder->expr()->like('word', ":word{$index}"));
            $termQueryBuilder->setParameter("word{$index}", $termValue . '%');
        }

        $termQueryBuilder->groupBy('term.model_uuid');
        $termQueryBuilder->addGroupBy('model.reference');
        $termQueryBuilder->addGroupBy('model.android_code_name');
        $termQueryBuilder->addGroupBy('model.variant');
        $termQueryBuilder->addGroupBy('serie.name');
        $termQueryBuilder->addGroupBy('serie.uuid');
        $termQueryBuilder->addGroupBy('manufacturer.name');
        $termQueryBuilder->orderBy('COUNT(CASE WHEN word = ANY(ARRAY[:words]) THEN 1 END)', 'DESC');
        $termQueryBuilder->addOrderBy('COUNT(*)', 'DESC');
        $termQueryBuilder->addOrderBy('manufacturer.name', 'ASC');
        $termQueryBuilder->addOrderBy('serie.name', 'ASC');
        $termQueryBuilder->addOrderBy('model.reference', 'ASC');

        $termQueryBuilder->setMaxResults(10);

        return array_map(
            fn ($row) => new ModelHeader(
                $row['uuid'],
                $row['reference'],
                $row['android_code_name'],
                $row['variant'],
                $row['serie'],
                $row['serie_uuid'],
                $row['manufacturer'],
            ),
            $termQueryBuilder->executeQuery()->fetchAllAssociative(),
        );
    }
}
