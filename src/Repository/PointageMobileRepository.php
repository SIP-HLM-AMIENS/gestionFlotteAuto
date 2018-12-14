<?php

namespace App\Repository;

use App\Entity\PointageMobile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PointageMobile|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointageMobile|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointageMobile[]    findAll()
 * @method PointageMobile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointageMobileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PointageMobile::class);
    }

    // /**
    //  * @return PointageMobile[] Returns an array of PointageMobile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PointageMobile
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
