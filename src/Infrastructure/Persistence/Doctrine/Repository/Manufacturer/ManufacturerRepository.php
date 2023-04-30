<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Manufacturer;

use App\Domain\Manufacturer\Repository\ManufacturerRepositoryInterface;
use App\Domain\Model\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

final class ManufacturerRepository extends ServiceEntityRepository implements ManufacturerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manufacturer::class);
    }

    public function add(Manufacturer $manufacturer): Manufacturer
    {
        $this->getEntityManager()->persist($manufacturer);

        return $manufacturer;
    }

    public function isNameUsed(string $name): bool
    {
        return $this->createQueryBuilder('m')
            ->select([
                'COUNT(m)',
            ])
            ->andWhere('LOWER(m.name) LIKE LOWER(:name)')
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleScalarResult() > 0
        ;
    }

    public function findManufacturers(int $page, int $pageSize): Paginator
    {
        $query = $this->createQueryBuilder('m')
            ->addSelect([
                'm.uuid',
                'm.name',
            ])
            ->orderBy('m.name', Criteria::ASC)
            ->setFirstResult($pageSize * ($page - 1)) // set the offset
            ->setMaxResults($pageSize)
            ->getQuery()
        ;

        $paginator = new Paginator($query);

        return $paginator;
    }
}
