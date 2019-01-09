<?php

namespace App\Repository;

use App\Entity\Rooster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rooster|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rooster|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rooster[]    findAll()
 * @method Rooster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoosterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rooster::class);
    }

    // /**
    //  * @return Rooster[] Returns an array of Rooster objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rooster
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
