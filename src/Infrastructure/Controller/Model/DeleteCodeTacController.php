<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use App\Application\CommandBusInterface;
use App\Application\Model\Command\DeleteCodeTacCommand;
use App\Domain\Model\Model;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

final class DeleteCodeTacController
{
    public function __construct(
        private RouterInterface $router,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/models/{model}/code-tac/{codeTac}/delete', name: 'app_code_tac_delete', methods: ['POST'], requirements: ['codeTac' => '\d{8}'])]
    public function __invoke(Model $model, string $codeTac): Response
    {
        $command = new DeleteCodeTacCommand($codeTac);

        $this->commandBus->handle($command);

        return new RedirectResponse(
            $this->router->generate('app_model_view', ['serie' => $model->getSerie()->getUuid(), 'model' => $model->getUuid()]),
            Response::HTTP_SEE_OTHER,
        );
    }
}
