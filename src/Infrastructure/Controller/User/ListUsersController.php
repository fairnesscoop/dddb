<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User;

use App\Application\QueryBusInterface;
use App\Application\User\Query\ListUsersQuery;
use App\Domain\User\Enum\RoleEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListUsersController
{
    public function __construct(
        private \Twig\Environment $twig,
        private QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/users', name: 'app_users_list', methods: ['GET'])]
    public function __invoke()
    {
        $users = $this->queryBus->handle(new ListUsersQuery());

        return new Response(
            content: $this->twig->render(
                name: 'users/list.html.twig',
                context: [
                    'users' => $users,
                    'adminRole' => RoleEnum::ROLE_ADMIN->value,
                    'contributorRole' => RoleEnum::ROLE_CONTRIBUTOR->value,
                ],
            ),
        );
    }
}
