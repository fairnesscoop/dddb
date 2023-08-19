<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\User;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', trim(strtolower($email)))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByUuid(string $uuid): User
    {
        $user = $this->find($uuid);

        if (\is_null($user)) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function add(User $user): User
    {
        $this->getEntityManager()->persist($user);

        return $user;
    }

    public function findUsers(int $page, int $pageSize): array
    {
        $query = $this->createQueryBuilder('u')
            ->setFirstResult($pageSize * ($page - 1)) // set the offset
            ->setMaxResults($pageSize)
            ->getQuery();

        $paginator = new Paginator($query);
        $count = \count($paginator);

        $result = [
            'items' => [],
            'totalItems' => $count,
        ];

        foreach ($paginator as $user) {
            array_push($result['items'], $user);
        }

        return $result;
    }
}
