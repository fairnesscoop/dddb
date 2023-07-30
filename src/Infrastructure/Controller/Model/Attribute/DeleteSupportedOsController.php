<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\Attribute;

use App\Application\CommandBusInterface;
use App\Application\SupportedOsList\Command\DeleteSupportedOsCommand;
use App\Domain\Model\Model;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class DeleteSupportedOsController
{
    public function __construct(
        private RouterInterface $router,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/models/{model}/supported_os_list/{supportedOsId}/delete',
        name: 'app_attribute_supported_os_list_delete',
        methods: ['POST'],
        requirements: ['supportedOsId' => '\d+'],
    )]
    public function __invoke(Model $model, int $supportedOsId): Response
    {
        $command = new DeleteSupportedOsCommand($model, $supportedOsId);

        $this->commandBus->handle($command);

        return new RedirectResponse(
            $this->router->generate('app_attribute_supported_os_list', ['model' => $model->getUuid()]),
            Response::HTTP_SEE_OTHER,
        );
    }
}
