<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model;

use App\Domain\Model\Manufacturer;
use App\Domain\Model\Model;
use App\Domain\Model\Serie;
use App\Domain\ModelEntity\Repository\ModelRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

final class ModelRepository extends ServiceEntityRepository implements ModelRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    public function add(Model $model): Model
    {
        $this->getEntityManager()->persist($model);

        return $model;
    }

    public function isCodeNameUsed(Manufacturer $manufacturer, string $codeName): bool
    {
        return $this->createQueryBuilder('m')
            ->select([
                'COUNT(m)',
            ])
            ->join('m.serie', 's')
            ->join('s.manufacturer', 'mf', 'WITH', 'mf = :manufacturer')->setParameter('manufacturer', $manufacturer->getUuid())
            ->andWhere('LOWER(m.codeName) LIKE LOWER(:codeName)')->setParameter('codeName', $codeName)
            ->getQuery()
            ->getSingleScalarResult() > 0
        ;
    }

    public function findModels(Serie $serie, int $page, int $pageSize): Paginator
    {
        $query = $this->createQueryBuilder('m')
            ->addSelect([
                'm.uuid',
                'm.codeName',
            ])
            ->andWhere('m.serie = :serie')->setParameter('serie', $serie)
            ->orderBy('m.codeName', Criteria::ASC)
            ->setFirstResult($pageSize * ($page - 1)) // set the offset
            ->setMaxResults($pageSize)
            ->getQuery()
        ;

        $paginator = new Paginator($query);

        return $paginator;
    }
}
