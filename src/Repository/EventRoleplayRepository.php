<?php

namespace App\Repository;

use App\Entity\EventRoleplay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventRoleplay|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRoleplay|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRoleplay[]    findAll()
 * @method EventRoleplay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRoleplayRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventRoleplay::class);
    }

//    /**
//     * @return EventRoleplay[] Returns an array of EventRoleplay objects
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
    public function findOneBySomeField($value): ?EventRoleplay
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
