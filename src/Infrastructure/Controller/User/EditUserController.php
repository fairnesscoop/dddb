<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditUserController
{
    public function __construct(
        private \Twig\Environment $twig,
    ) {
    }

    #[Route('/users/:id/edit', name: 'app_user_edit')]
    public function __invoke()
    {
        return new Response(
            content: $this->twig->render(
                name: 'user/edit.html.twig',
            ),
        );
    }
}
