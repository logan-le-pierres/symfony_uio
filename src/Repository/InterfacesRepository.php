<?php

namespace App\Repository;

use App\Entity\Interfaces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Interfaces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interfaces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interfaces[]    findAll()
 * @method Interfaces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterfacesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interfaces::class);
    }

    // /**
    //  * @return Interfaces[] Returns an array of Interfaces objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Interfaces
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
