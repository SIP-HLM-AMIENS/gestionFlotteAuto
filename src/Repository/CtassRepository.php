<?php

namespace App\Repository;

use App\Entity\Ctass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ctass|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ctass|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ctass[]    findAll()
 * @method Ctass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CtassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ctass::class);
    }

    // /**
    //  * @return Ctass[] Returns an array of Ctass objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ctass
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
