<?php

namespace App\Repository;

use App\Entity\SubscribtionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubscribtionType>
 *
 * @method SubscribtionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscribtionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscribtionType[]    findAll()
 * @method SubscribtionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscribtionTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscribtionType::class);
    }

    //    /**
    //     * @return SubscribtionType[] Returns an array of SubscribtionType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SubscribtionType
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
