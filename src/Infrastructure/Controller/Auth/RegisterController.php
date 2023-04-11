<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Auth;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController
{
    public function __construct(
        private \Twig\Environment $twig,
    ) {
    }

    #[Route('/register', name: 'register', methods: ['GET'])]
    public function __invoke(): Response
    {
        return new Response(
            $this->twig->render(name: 'auth/register.html.twig')
        );
    }
}
