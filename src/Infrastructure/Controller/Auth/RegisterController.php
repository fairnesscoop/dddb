<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Auth;

use App\Application\CommandBusInterface;
use App\Application\User\Command\RegisterUserCommand;
use App\Infrastructure\Form\Auth\RegisterFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterController
{
    public function __construct(
        private \Twig\Environment $twig,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/register', name: 'app_register', methods: ['GET'])]
    public function __invoke(): Response
    {
        $command = new RegisterUserCommand('Benoit', 'Paquier', 'benoit@fairness.coop', 'temptemp');
        $form = $this->formFactory->create(RegisterFormType::class);

        $this->commandBus->handle($command);

        return new Response(
            $this->twig->render(
                name: 'auth/register.html.twig',
                context: [
                    'form' => $form->createView(),
                ],
            ),
        );
    }
}
