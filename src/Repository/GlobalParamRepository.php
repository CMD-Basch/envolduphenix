<?php

namespace App\Repository;

use App\Entity\GlobalParam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GlobalParam|null find($id, $lockMode = null, $lockVersion = null)
 * @method GlobalParam|null findOneBy(array $criteria, array $orderBy = null)
 * @method GlobalParam[]    findAll()
 * @method GlobalParam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlobalParamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GlobalParam::class);
    }

//    /**
//     * @return GlobalParam[] Returns an array of GlobalParam objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GlobalParam
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
