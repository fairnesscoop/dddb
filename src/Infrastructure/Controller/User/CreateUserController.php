<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User;

use App\Application\CommandBusInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Infrastructure\Form\User\CreateFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

final class CreateUserController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/users/create', name: 'app_create_user', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $command = new CreateUserCommand();
        $form = $this->formFactory->create(CreateFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->commandBus->handle($command);

            return new RedirectResponse(
                url: $this->router->generate('app_login'),
                status: Response::HTTP_SEE_OTHER,
            );
        }

        return new Response(
            $this->twig->render(
                name: 'users/create.html.twig',
                context: [
                    'form' => $form->createView(),
                ],
            ),
        );
    }
}
