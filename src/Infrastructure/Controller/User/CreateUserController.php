<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User;

use App\Application\CommandBusInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Domain\User\Exception\UserAlreadyRegisteredException;
use App\Infrastructure\Form\User\FormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CreateUserController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/users/create', name: 'app_user_create', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $command = new CreateUserCommand();
        $form = $this->formFactory->create(FormType::class, $command);
        $form->handleRequest($request);
        $hasCommandFailed = false;

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->commandBus->handle($command);

                return new RedirectResponse(
                    url: $this->router->generate('app_users_list'),
                    status: Response::HTTP_SEE_OTHER,
                );
            } catch (UserAlreadyRegisteredException) {
                $hasCommandFailed = true;
                $errorMsg = $this->translator->trans('users.create.form.email.already_exist', [], 'validators');
                $form->get('email')->addError(new FormError($errorMsg));
            }
        }

        return new Response(
            content: $this->twig->render(
                name: 'users/create.html.twig',
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
