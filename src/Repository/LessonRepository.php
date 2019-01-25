<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array());
    }

    public function getBeschikbareLessons($memberid)
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery("SELECT a FROM App:lesson a WHERE :memberid NOT MEMBER OF a.member");

        $query->setParameter('memberid',$memberid);

        return $query->getResult();
    }

    public function getIngeschrevenLessons($memberid)
    {

        $em=$this->getEntityManager();
        $query=$em->createQuery("SELECT a FROM App:lesson a WHERE :memberid MEMBER OF a.member");

        $query->setParameter('memberid',$memberid);

        return $query->getResult();
    }

  


    // /**
    //  * @return Lesson[] Returns an array of Lesson objects
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
    public function findOneBySomeField($value): ?Lesson
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
