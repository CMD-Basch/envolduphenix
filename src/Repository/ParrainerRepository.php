<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Parrainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Parrainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parrainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parrainer[]    findAll()
 * @method Parrainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParrainerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Parrainer::class);
    }

//    /**
//     * @return Parrainer[] Returns an array of Parrainer objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Parrainer
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
