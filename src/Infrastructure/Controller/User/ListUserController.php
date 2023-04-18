<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User;

use App\Infrastructure\Persistence\Doctrine\Repository\User\UserRepository;
use Symfony\Component\Routing\Annotation\Route;

final class ListUserController
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    #[Route('/users', name: 'app_list_users')]
    public function __invoke()
    {
        dump('hello');
    }
}
