<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Repository;

use App\LaboratoryDictionary\Infrastructure\Doctrine\Entity\ReferenceRulesActiveEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReferenceRulesActiveEntity>
 */
class ReferenceRulesActiveEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferenceRulesActiveEntity::class);
    }

    //    /**
    //     * @return ReferenceRulesActiveEntity[] Returns an array of ReferenceRulesActiveEntity objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ReferenceRulesActiveEntity
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
