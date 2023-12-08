<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use App\Application\CommandBusInterface;
use App\Application\Model\Command\CreateModelCommand;
use App\Domain\Model\Exception\ReferenceAlreadyExistsException;
use App\Domain\Model\Serie;
use App\Infrastructure\Form\Model\CreateFormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CreateModelController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/series/{serie}/models/create', name: 'app_model_create', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Serie $serie): Response
    {
        $command = new CreateModelCommand($serie);
        $form = $this->formFactory->create(CreateFormType::class, $command, ['serieUuid' => $serie->getUuid()]);
        $form->handleRequest($request);
        $hasCommandFailed = false;

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->commandBus->handle($command);

                return new RedirectResponse(
                    url: $this->router->generate('app_models_list', ['serie' => $serie->getUuid()]),
                    status: Response::HTTP_SEE_OTHER,
                );
            } catch (ReferenceAlreadyExistsException) {
                $hasCommandFailed = true;
                $errorMsg = $this->translator->trans('models.create.form.reference.alreadyExists', [], 'validators');
                $form->get('reference')->addError(new FormError($errorMsg));
            }
        }

        return new Response(
            content: $this->twig->render(
                name: 'models/create.html.twig',
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
