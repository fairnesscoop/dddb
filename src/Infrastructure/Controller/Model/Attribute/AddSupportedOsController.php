<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\Attribute;

use App\Application\CommandBusInterface;
use App\Application\SupportedOsList\Command\AddSupportedOsCommand;
use App\Domain\Model\Model;
use App\Infrastructure\Form\Model\Attribute\AddSupportedOsFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class AddSupportedOsController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/models/{model}/supported_os_list/add', name: 'app_attribute_supported_os_list_add', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Model $model): Response
    {
        $command = new AddSupportedOsCommand($model);

        $formsupportedOs = $this->formFactory->create(AddSupportedOsFormType::class, $command, [
            'action' => $this->router->generate('app_attribute_supported_os_list_add', ['model' => $model->getUuid()]),
        ]);

        $formsupportedOs->handleRequest($request);
        $response = new Response();

        if ($formsupportedOs->isSubmitted()) {
            if ($formsupportedOs->isValid()) {
                $this->commandBus->handle($command);

                return new RedirectResponse(
                    $this->router->generate('app_attribute_supported_os_list', ['model' => $model->getUuid()]),
                    Response::HTTP_SEE_OTHER,
                );
            }

            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response->setContent($this->twig->render('models/attributes/_supportedOsListAdd.html.twig', [
            'model' => $model,
            'formSupportedOs' => $formsupportedOs->createView(),
        ]));

        return $response;
    }
}
