<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Auth;

use App\Infrastructure\Form\Auth\LoginFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController
{
    public function __construct(
        private \Twig\Environment $twig,
        private AuthenticationUtils $authenticationUtils,
        private FormFactoryInterface $formFactory,
    ) {
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function __invoke(): Response
    {
        $form = $this->formFactory->create(LoginFormType::class);
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();

        dump($form);

        return new Response(
            $this->twig->render(
                name: 'auth/login.html.twig',
                context: [
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'form' => $form->createView()
                ],
            ),
        );
    }
}
