<?php

namespace App\Repository;

use App\Entity\Lesson;
use App\Entity\Member;
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
        return $this->findBy(array('training' => $trainingid), array('date'=>'ASC'));
    }


    public function getBeschikbareLessons($memberid)
    {  
        

        //$memberid=2;
        $em=$this->getEntityManager();
        $member=$em->getRepository(Member::class)->findOneBy(['id'=>$memberid]);
        $query=$em->createQuery("SELECT l FROM App:lesson l WHERE NOT EXISTS (SELECT IDENTITY(r.lesson) FROM App:registration r WHERE r.member=:member AND r.lesson=l)");
        $query->setParameter('member',$member);
        $beschikbarelessen=$query->getResult();

       /*
        $query=$em->createQuery("SELECT l FROM App:lesson l JOIN l.registration r  WHERE  r.member=:member");
       
        $query->setParameter('member',$member);
        
       $ingeschrevenlessen=$query->getResult();
       $allelessen=$em->getRepository(Member::class)->findAll();
        $beschikbarelessen=array_udiff($allelessen,$ingeschrevenlessen,
        function ($i, $a) {
            return $i->getId() - $a->getId();
        }
      );*/

        return $beschikbarelessen;
    }

    public function getIngeschrevenLessons($memberid)
    {
      

        $em=$this->getEntityManager();
        $member=$em->getRepository(Member::class)->findOneBy(['id'=>$memberid]);
        //$query=$em->createQuery("SELECT a FROM App:lesson a WHERE :member MEMBER OF a.registration ORDER BY a.date");
        $query=$em->createQuery("SELECT l FROM App:lesson l WHERE EXISTS (SELECT IDENTITY(r.lesson) FROM App:registration r WHERE r.member=:member AND r.lesson=l)");
        $query->setParameter('member',$member);
       

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
