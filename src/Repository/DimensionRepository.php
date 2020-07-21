<?php

namespace App\Repository;

use App\Entity\Dimension;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Dimension|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dimension|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dimension[]    findAll()
 * @method Dimension[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DimensionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dimension::class);
    }

	/**
     * @param string|null $term
     */
	public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('d');
        if ($term) {
            $qb->andWhere('d.name_dimension LIKE :term')
                ->setParameter('term', '%' . $term . '%')
            ;
        }
        return $qb
            ->orderBy('d.name_dimension', 'ASC')
        ;
    }
    // /**
    //  * @return Dimension[] Returns an array of Dimension objects
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
    public function findOneBySomeField($value): ?Dimension
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
