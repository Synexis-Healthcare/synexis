<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Repository;

use App\LaboratoryDictionary\Infrastructure\Doctrine\Entity\SpecimenDefinitionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SpecimenDefinitionEntity>
 */
class SpecimenDefinitionEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecimenDefinitionEntity::class);
    }

    //    /**
    //     * @return SpecimenDefinitionEntity[] Returns an array of SpecimenDefinitionEntity objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SpecimenDefinitionEntity
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
