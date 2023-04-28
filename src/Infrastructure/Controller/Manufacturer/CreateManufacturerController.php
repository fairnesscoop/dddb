<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Manufacturer;

use App\Application\CommandBusInterface;
use App\Application\Manufacturer\Command\CreateManufacturerCommand;
use App\Domain\Manufacturer\Exception\NameAlreadyExistsException;
use App\Infrastructure\Form\Manufacturer\CreateFormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CreateManufacturerController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/manufacturers/create', name: 'app_manufacturer_create', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $command = new CreateManufacturerCommand();
        $form = $this->formFactory->create(CreateFormType::class, $command);
        $form->handleRequest($request);
        $hasCommandFailed = false;

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->commandBus->handle($command);

                return new RedirectResponse(
                    url: $this->router->generate('app_manufacturers_list'),
                    status: Response::HTTP_SEE_OTHER,
                );
            } catch (NameAlreadyExistsException) {
                $hasCommandFailed = true;
                $errorMsg = $this->translator->trans('manufacturers.create.form.name.already_exist', [], 'validators');
                $form->get('name')->addError(new FormError($errorMsg));
            }
        }

        return new Response(
            content: $this->twig->render(
                name: 'manufacturers/create.html.twig',
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
