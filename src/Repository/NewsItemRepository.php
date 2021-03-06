<?php

namespace App\Repository;

use App\Entity\NewsItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsItem[]    findAll()
 * @method NewsItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsItem::class);
    }

    // /**
    //  * @return NewsItem[] Returns an array of NewsItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsItem
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function hasByGuid(string $guid): bool
    {
        return $this->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.guid = :guid')
                ->setParameter(':guid', $guid)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getLastItemGuid(): string
    {
        return $this->createQueryBuilder('t')
            ->select('t.guid')
            ->andWhere('t.last = :last')
            ->setParameter(':last', true)
            ->getQuery()->getSingleScalarResult();
    }
}
