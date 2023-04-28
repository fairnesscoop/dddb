<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User;

use App\Application\QueryBusInterface;
use App\Application\User\Query\ListUsersQuery;
use App\Domain\User\Enum\RoleEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ListUsersController
{
    public function __construct(
        private \Twig\Environment $twig,
        private QueryBusInterface $queryBus,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/users', name: 'app_users_list', methods: ['GET'])]
    public function __invoke(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $pageSize = min($request->query->getInt('pageSize', 20), 100);

        if ($pageSize <= 0 || $page <= 0) {
            throw new BadRequestHttpException(
                $this->translator->trans('invalid.page_or_page_size', [], 'validators'),
            );
        }

        $users = $this->queryBus->handle(
            new ListUsersQuery(
                page: $page,
                pageSize: $pageSize,
            ),
        );

        return new Response(
            content: $this->twig->render(
                name: 'users/list.html.twig',
                context: [
                    'users' => $users,
                    'totalUsers' => $users->totalItems,
                    'page' => $page,
                    'pageSize' => $pageSize,
                    'adminRole' => RoleEnum::ROLE_ADMIN->value,
                    'contributorRole' => RoleEnum::ROLE_CONTRIBUTOR->value,
                ],
            ),
        );
    }
}
