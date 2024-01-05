<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Search;

use App\Infrastructure\Persistence\Doctrine\Repository\Model\ModelRepository;
use Doctrine\DBAL\Connection;

class SearchIndexer
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ModelRepository $modelRepository,
    ) {
    }

    public function purge(): void
    {
        $this->connection->executeQuery('TRUNCATE TABLE term');
    }

    public function indexAll(): void
    {
        $models = $this->modelRepository->findAllModels();
        foreach ($models as $model) {
            $indexableManufacturer = $this->prepareString($model->manufacturer);
            $this->addWord($indexableManufacturer, $model->uuid);

            $indexableSerieWords = $this->tokenize($model->serie);
            foreach ($indexableSerieWords as $referenceWord) {
                $this->addWord($referenceWord, $model->uuid);
            }

            if (!empty($model->reference)) {
                $indexableReferenceWords = $this->tokenize($model->reference);
                foreach ($indexableReferenceWords as $referenceWord) {
                    $this->addWord($referenceWord, $model->uuid);
                }
            }

            $androidCodeName = $this->prepareString($model->androidCodeName);
            $this->addWord($androidCodeName, $model->uuid);
        }
    }

    private function addWord(string $word, string $uuid): void
    {
        $this->connection->executeStatement(
            'INSERT INTO term (word, model_uuid) VALUES(:word, :model_uuid) ON CONFLICT DO NOTHING',
            ['word' => $word, 'model_uuid' => $uuid],
        );
    }

    private function prepareString(string $rawText): string
    {
        $lcText = mb_strtolower($rawText);
        $alphanumText = preg_replace('/[^\w\s]/u', '', $lcText);

        return trim($alphanumText);
    }

    public function tokenize(string $rawText): array
    {
        $indexableString = $this->prepareString($rawText);

        return preg_split('/\s+/', $indexableString, 8);
    }
}
