<?php

namespace App\Repository;

use App\Entity\Les;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Les|null find($id, $lockMode = null, $lockVersion = null)
 * @method Les|null findOneBy(array $criteria, array $orderBy = null)
 * @method Les[]    findAll()
 * @method Les[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Les::class);
    }

    // /**
    //  * @return Les[] Returns an array of Les objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Les
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
