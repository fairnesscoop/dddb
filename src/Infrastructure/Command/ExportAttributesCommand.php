<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:export:attributes',
    description: 'Export model attributes to CSV file',
)]
class ExportAttributesCommand extends Command
{
    public function __construct(
        private readonly AttributeRepositoryInterface $attributeRepository,
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
            $filename = 'var/attributes.csv';
        }

        $attributes = $this->attributeRepository->findAllAttributes();

        $fp = fopen($filename, 'w');
        fwrite($fp, $this->serializer->serialize($attributes, CsvEncoder::FORMAT));

        $io->success("Attributes have been exported to {$filename}.");

        return Command::SUCCESS;
    }
}
