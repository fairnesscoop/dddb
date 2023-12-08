<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Domain\Model\Repository\ModelRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:export:models',
    description: 'Export models to CSV file',
)]
class ExportModelsCommand extends Command
{
    public function __construct(
        private readonly ModelRepositoryInterface $modelRepository,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filename', InputArgument::OPTIONAL, 'Output file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filename = $input->getArgument('filename');

        if (!$filename) {
            $filename = 'var/models.csv';
        }

        $models = $this->modelRepository->findAllModels();

        $fp = fopen($filename, 'w');
        fwrite($fp, $this->serializer->serialize($models, CsvEncoder::FORMAT));

        $io->success("Models have been exported to {$filename}.");

        return Command::SUCCESS;
    }
}
