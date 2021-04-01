<?php

namespace App\Repository;

use App\Entity\DeclarRemboursement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeclarRemboursement|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeclarRemboursement|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeclarRemboursement[]    findAll()
 * @method DeclarRemboursement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclarRemboursementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeclarRemboursement::class);
    }

    // /**
    //  * @return DeclarRemboursement[] Returns an array of DeclarRemboursement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeclarRemboursement
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
