<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Serie;

use App\Application\Serie\View\SerieHeader;
use App\Domain\Model\Manufacturer;
use App\Domain\Model\Model;
use App\Domain\Model\Serie;
use App\Domain\Serie\Repository\SerieRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

final class SerieRepository extends ServiceEntityRepository implements SerieRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function add(Serie $serie): Serie
    {
        $this->getEntityManager()->persist($serie);

        return $serie;
    }

    public function isNameUsed(Manufacturer $manufacturer, string $name): bool
    {
        return $this->createQueryBuilder('s')
            ->select([
                'COUNT(s)',
            ])
            ->andWhere('s.manufacturer = :manufacturer')->setParameter('manufacturer', $manufacturer)
            ->andWhere('LOWER(s.name) LIKE LOWER(:name)')->setParameter('name', $name)
            ->getQuery()
            ->getSingleScalarResult() > 0
        ;
    }

    public function findSeries(int $page, int $pageSize): Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->addSelect([
                's.uuid',
                's.name',
                'm.name AS manufacturer',
            ])
            ->join('s.manufacturer', 'm')
            ->orderBy('m.name', Criteria::ASC)
            ->addOrderBy('s.name', Criteria::ASC)
            ->setFirstResult($pageSize * ($page - 1)) // set the offset
            ->setMaxResults($pageSize)
            ->getQuery()
        ;

        $paginator = new Paginator($query);

        return $paginator;
    }

    /** @return SerieHeader[] */
    public function findAllSerieHeaders(): iterable
    {
        $subQb = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('model.uuid')
            ->from(Model::class, 'model')
            ->where('model.serie = s.uuid');

        $expr = $this->getEntityManager()->getExpressionBuilder();

        return $this->createQueryBuilder('s')
            ->addSelect([
                sprintf('NEW %s(s.uuid, s.name, m.name)', SerieHeader::class),
            ])
            ->join('s.manufacturer', 'm')
            ->where($expr->exists($subQb->getDQL()))
            ->orderBy('m.name', Criteria::ASC)
            ->addOrderBy('s.name', Criteria::ASC)
            ->getQuery()
            ->getResult()
        ;
    }
}
