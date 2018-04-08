<?php

namespace App\Repository;

use App\Entity\EventWargame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventWargame|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventWargame|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventWargame[]    findAll()
 * @method EventWargame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventWargameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventWargame::class);
    }

//    /**
//     * @return EventWargame[] Returns an array of EventWargame objects
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
    public function findOneBySomeField($value): ?EventWargame
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
