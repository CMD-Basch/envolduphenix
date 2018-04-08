<?php

namespace App\Repository;

use App\Entity\EventBoardgame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventBoardgame|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventBoardgame|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventBoardgame[]    findAll()
 * @method EventBoardgame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventBoardgameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventBoardgame::class);
    }

//    /**
//     * @return EventBoardgame[] Returns an array of EventBoardgame objects
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
    public function findOneBySomeField($value): ?EventBoardgame
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
