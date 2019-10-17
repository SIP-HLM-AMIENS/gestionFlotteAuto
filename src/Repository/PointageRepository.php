<?php

namespace App\Repository;

use App\Entity\Pointage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pointage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pointage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pointage[]    findAll()
 * @method Pointage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pointage::class);
    }

    // /**
    //  * @return Pointage[] Returns an array of Pointage objects
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
    public function findOneBySomeField($value): ?Pointage
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByMois($voiture,$mois, $fdm): array
    {
        $from = new \DateTime(date('Y-m-d', mktime(0,0,0,$mois,1)));
        $to = new \DateTime(date('Y-m-d', mktime(0,0,0,$mois,$fdm)));

        $qb =  $this->createQueryBuilder('p')
        ->leftjoin('p.reservation','r')
        ->andWhere('p.sortie BETWEEN :from AND :to')
        ->andWhere('r.voiture = :voiture')
        ->setParameter('from', $from)
        ->setParameter('to', $to)
        ->setParameter('voiture', $voiture)
        ->getQuery();

        return $qb->execute();
    }

    public function findByJour($voiture, $jour): string
    {
        $date = \DateTime::createFromFormat('Y-m-d', $jour);

        $qb = $this->createQueryBuilder('p')
        ->leftjoin('p.reservation','r')
        ->andWhere('p.sortie BETWEEN :from AND :to')
        ->andWhere('r.voiture = :voiture')
        ->setParameter('from', $date->format('Y-m-d 00:00:00'))
        ->setParameter('to', $date->format('Y-m-d 23:59:59'))
        ->setParameter('voiture', $voiture)
        ->select('COUNT(p)')
        ->getQuery();
        

        return $qb->getSingleScalarResult();
    }
}
