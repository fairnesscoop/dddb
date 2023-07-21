<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Serie;

use App\Application\CommandBusInterface;
use App\Application\Serie\Command\CreateSerieCommand;
use App\Domain\Serie\Exception\NameAlreadyExistsException;
use App\Infrastructure\Form\Serie\CreateFormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CreateSerieController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/series/create', name: 'app_serie_create', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $command = new CreateSerieCommand();
        $form = $this->formFactory->create(CreateFormType::class, $command);
        $form->handleRequest($request);
        $hasCommandFailed = false;

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->commandBus->handle($command);

                return new RedirectResponse(
                    url: $this->router->generate('app_series_list'),
                    status: Response::HTTP_SEE_OTHER,
                );
            } catch (NameAlreadyExistsException) {
                $hasCommandFailed = true;
                $errorMsg = $this->translator->trans('series.create.form.name.alreadyExists', [], 'validators');
                $form->get('name')->addError(new FormError($errorMsg));
            }
        }

        return new Response(
            content: $this->twig->render(
                name: 'series/create.html.twig',
                context: [
                    'form' => $form->createView(),
                ],
            ),
            status: ($form->isSubmitted() && !$form->isValid()) || $hasCommandFailed
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_OK,
        );
    }
}
