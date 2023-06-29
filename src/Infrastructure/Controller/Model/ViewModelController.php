<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use App\Application\CommandBusInterface;
use App\Application\Model\Command\CreateCodeTacCommand;
use App\Domain\Model\Model;
use App\Infrastructure\Form\Model\CreateCodeTacFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

final class ViewModelController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/series/{serie}/models/{model}', name: 'app_model_view', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Model $model): Response
    {
        $command = new CreateCodeTacCommand($model);
        $formCodeTac = $this->formFactory->create(CreateCodeTacFormType::class, $command);

        $formCodeTac->handleRequest($request);

        if ($formCodeTac->isSubmitted() && $formCodeTac->isValid()) {
            $this->commandBus->handle($command);

            return new RedirectResponse($request->getUri());
        }

        return new Response(
            content: $this->twig->render(
                name: 'models/view.html.twig',
                context: [
                    'model' => $model,
                    'formCodeTac' => $formCodeTac->createView(),
                    'asideDetailsActive' => 'series',
                    'asideDetailsActiveContextualLink' => [
                        'parent' => 'app_series_list',
                        'label' => $model->getSerie()->getName(),
                        'link' => $this->router->generate('app_models_list', ['serie' => $model->getSerie()->getUuid()]),
                    ],
                    'highlightedItem' => 'app_series_list',
                ],
            ),
        );
    }
}
