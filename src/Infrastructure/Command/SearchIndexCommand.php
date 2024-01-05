<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Infrastructure\Persistence\Doctrine\Search\SearchIndexer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:search:index',
    description: 'Reindex models for text search',
)]
class SearchIndexCommand extends Command
{
    public function __construct(
        private readonly SearchIndexer $searchIndexer,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Delete existing index');
        $this->searchIndexer->purge();
        $io->info('Start to index all models');
        $this->searchIndexer->indexAll();

        $io->success('Indexation complete.');

        return Command::SUCCESS;
    }
}
