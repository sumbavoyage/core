<?php

namespace Svs\Core\Repository;

use Svs\Core\Entity\InclusionGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InclusionGroup>
 *
 * @method InclusionGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method InclusionGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method InclusionGroup[]    findAll()
 * @method InclusionGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InclusionGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InclusionGroup::class);
    }

    public function add(InclusionGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InclusionGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return InclusionGroup[] Returns an array of InclusionGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InclusionGroup
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
