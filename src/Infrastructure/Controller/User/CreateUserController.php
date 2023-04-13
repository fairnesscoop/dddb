<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User;

use App\Application\CommandBusInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Infrastructure\Form\User\CreateFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateUserController
{
    public function __construct(
        private \Twig\Environment $twig,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/users/create', name: 'app_create_user', methods: ['GET'])]
    public function __invoke(): Response
    {
        $command = new CreateUserCommand('Benoit', 'Paquieddddr', 'benoit@fairness.coop', 'temptemp');
        $form = $this->formFactory->create(CreateFormType::class);

        $this->commandBus->handle($command);

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
