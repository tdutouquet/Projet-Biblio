<?php

namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 *
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    public function findEnmprunt(): array
{
    $query = $this->createQueryBuilder('e')
        ->where('e.dateRendu IS NULL')
        ->getQuery();

    $emprunts = $query->getResult();
    $empruntEnCours = [];

    foreach ($emprunts as $emprunt) {
        $empruntEnCours [$emprunt->getLivres()->getId()] = $emprunt;
    }

    return $empruntEnCours;
}

public function findEmpruntsWithDetailsByUser($userId)
{
    return $this->createQueryBuilder('e')
        ->select('e, livres, user')
        ->leftJoin('e.livres', 'livres')
        ->leftJoin('e.user', 'user')
        ->andWhere('user.id = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();
}

//    /**
//     * @return Emprunt[] Returns an array of Emprunt objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Emprunt
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
