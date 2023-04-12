<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Auth;

use App\Infrastructure\Form\Auth\RegisterFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterController
{
    public function __construct(
        private \Twig\Environment $twig,
        private FormFactoryInterface $formFactory,
    ) {
    }

    #[Route('/register', name: 'app_register', methods: ['GET'])]
    public function __invoke(): Response
    {
        $form = $this->formFactory->create(RegisterFormType::class);

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
