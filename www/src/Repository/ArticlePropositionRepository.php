<?php

namespace App\Repository;

use App\Entity\ArticleProposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleProposition>
 *
 * @method ArticleProposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleProposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleProposition[]    findAll()
 * @method ArticleProposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlePropositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleProposition::class);
    }

//    /**
//     * @return ArticleProposition[] Returns an array of ArticleProposition objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArticleProposition
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
