<?php

namespace Svs\Core\Repository;

use Svs\Core\Entity\ExclusionGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExclusionGroup>
 *
 * @method ExclusionGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExclusionGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExclusionGroup[]    findAll()
 * @method ExclusionGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExclusionGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExclusionGroup::class);
    }

    public function add(ExclusionGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExclusionGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExclusionGroup[] Returns an array of ExclusionGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExclusionGroup
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
