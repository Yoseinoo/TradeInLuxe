<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function save(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOne($params = ''): ?Produit
    {
        $queryBuilder = $this->createQueryBuilder('produit');


        $this->getParams($queryBuilder, $params);

        $query = $queryBuilder->getQuery();
        $query->useQueryCache(true);
        $query->enableResultCache();

        try {
            return $query->getOneOrNullResult();
        } catch (\Doctrine\ORM\NonUniqueResultException) {
            return null;
        }
    }

    public function getAll($params = ''): array
    {
        $queryBuilder = $this->createQueryBuilder('produit');

        $this->getParams($queryBuilder, $params);

        $query = $queryBuilder->getQuery();

        $query->useQueryCache(true);
        $query->enableResultCache();

        return $query->getResult();
    }

    public function getAllQueryBuilder($params = ''): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('produit')
            ->select('produit')
        ;

        $this->getParams($queryBuilder, $params);

        return $queryBuilder;
    }

    private function getParams($queryBuilder, $params = '')
    {
        parse_str($params, $args);

        if (!empty($args['name'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('produit.name', ':name')
            )
            ->setParameter('name', $args['name']);
        }

        if (!empty($args['categorie'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('produit.categorie', ':categorie')
            )
            ->setParameter('categorie', $args['categorie']);
        }

        if (isset($args['isEnabled'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('produit.isEnabled', ':isEnabled')
            )
            ->setParameter('isEnabled', $args['isEnabled'], \PDO::PARAM_BOOL);
        }

        if (isset($args['deleted'])) {
            if ($args['deleted'] === 'true') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNotNull('produit.deletedAt')
                );
            } elseif ($args['deleted'] === 'false') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNull('produit.deletedAt')
                );
            }
        }

        if (!empty($args['orderby'])) {
            $direction = $args['order'] ?? 'asc'; 
            $queryBuilder->orderBy('produit.' . $args['orderby'], $direction);
        }

        if (!empty($args['search'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('produit.id', ':searchInt'),
                    $queryBuilder->expr()->like('LOWER(produit.name)', ':search'),
                )
            );
            $queryBuilder->setParameter('search', '%' . strtolower($args['search']) . '%');
            $queryBuilder->setParameter('searchInt', (int) $args['search']);
        }
    }


//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
