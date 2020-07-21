<?php

namespace App\Repository;

use App\Entity\SiteUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SiteUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteUser[]    findAll()
 * @method SiteUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SiteUser::class);
    }

    // /**
    //  * @return SiteUser[] Returns an array of SiteUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SiteUser
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
