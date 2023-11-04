<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Application\CommandBusInterface;
use App\Application\Manufacturer\Command\CreateManufacturerCommand;
use App\Application\Model\Command\CreateModelCommand;
use App\Application\Serie\Command\CreateSerieCommand;
use App\Application\SupportedOsList\Command\AddSupportedOsCommand;
use App\Domain\Manufacturer\Repository\ManufacturerRepositoryInterface;
use App\Domain\Model\Manufacturer;
use App\Domain\Model\Model;
use App\Domain\Model\Repository\ModelRepositoryInterface;
use App\Domain\Model\Serie;
use App\Domain\Os\OsVersionList;
use App\Domain\Serie\Repository\SerieRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:import:lineage-model',
    description: 'Import lineage model to database',
)]
class ImportLineageModelCommand extends Command
{
    private Model|null $mainModel = null;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ManufacturerRepositoryInterface $manufacturerRepository,
        private readonly SerieRepositoryInterface $serieRepository,
        private readonly ModelRepositoryInterface $modelRepository,
        private readonly CommandBusInterface $commandBus,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filename', InputArgument::REQUIRED, 'Yaml file from lineage wiki')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filename = $input->getArgument('filename');

        if (!file_exists($filename)) {
            $io->error("{$filename}: File not found");

            return Command::FAILURE;
        }

        /** @var LineageModel $lineageModel */
        $lineageModel = $this->serializer->deserialize(file_get_contents($filename), LineageModel::class, YamlEncoder::FORMAT);
        $existingManufacturerUuid = $this->manufacturerRepository->findUuidByName($lineageModel->vendor);
        if ($existingManufacturerUuid === null) {
            $question = sprintf('"%s" manufacturer not found, do you want to create it?', $lineageModel->vendor);
            $response = $io->askQuestion(new ConfirmationQuestion($question));
            if ($response === false) {
                $io->warning('Model not imported');

                return Command::FAILURE;
            }

            /** @var Manufacturer $manufacturer */
            $manufacturer = $this->commandBus->handle(new CreateManufacturerCommand($lineageModel->vendor));
            $manufacturerUuid = $manufacturer->getUuid();
            $io->info("Manufacturer {$manufacturer->getName()} created");
        } else {
            $manufacturerUuid = $existingManufacturerUuid;
        }

        $existingSerieUuid = $this->serieRepository->findUuidByName($manufacturerUuid, $lineageModel->name);
        if ($existingSerieUuid === null) {
            $question = sprintf('"%s" serie not found, do you want to create it?', $lineageModel->name);
            $response = $io->askQuestion(new ConfirmationQuestion($question));
            if ($response === false) {
                $io->warning('Model not imported');

                return Command::FAILURE;
            }

            $manufacturerReference = $this->entityManager->getReference(Manufacturer::class, $manufacturerUuid);
            /** @var Serie $serie */
            $serie = $this->commandBus->handle(new CreateSerieCommand($lineageModel->name, $manufacturerReference));
            $serieUuid = $serie->getUuid();
            $io->info("Serie {$serie->getName()} created");
        } else {
            $serieUuid = $existingSerieUuid;
        }

        $mainVersion = strtok($lineageModel->currentBranch, '.');

        $codeNames = empty($lineageModel->models) ? [$lineageModel->androidCode] : $lineageModel->models;
        foreach ($codeNames as $codeName) {
            $existingModel = $this->modelRepository->findModelByCodeName($serieUuid, $codeName);
            if (\is_null($existingModel)) {
                $this->createModel($serieUuid, $codeName, $lineageModel->androidCode, $mainVersion);
                $io->info("Codename {$codeName} has been imported.");
            } elseif ($this->mainModel === null) {
                $this->mainModel = $existingModel;
            }
        }

        $io->success('Model has been imported.');

        return Command::SUCCESS;
    }

    private function createModel(string $serieUuid, string $codeName, string $androidCode, string $latestLineageVersion): void
    {
        $serieReference = $this->entityManager->getReference(Serie::class, $serieUuid);

        $model = $this->commandBus->handle(new CreateModelCommand($serieReference, $codeName, $this->mainModel));
        if ($this->mainModel === null) {
            $this->mainModel = $model;
        }
        $osList = new OsVersionList();
        $osVersion = $osList->getLineageOsVersion($latestLineageVersion);
        $this->commandBus->handle(new AddSupportedOsCommand(
            $model,
            $osVersion,
            "https://wiki.lineageos.org/devices/{$androidCode}/",
        ));
    }
}
