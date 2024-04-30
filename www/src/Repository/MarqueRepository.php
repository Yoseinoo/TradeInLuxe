<?php

namespace App\Repository;

use App\Entity\Marque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Marque>
 *
 * @method Marque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marque[]    findAll()
 * @method Marque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marque::class);
    }

    public function save(Marque $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOne($params = ''): ?Marque
    {
        $queryBuilder = $this->createQueryBuilder('marque');

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
        $queryBuilder = $this->createQueryBuilder('marque');

        $this->getParams($queryBuilder, $params);

        $query = $queryBuilder->getQuery();

        $query->useQueryCache(true);
        $query->enableResultCache();

        return $query->getResult();
    }

    private function getParams($queryBuilder, $params = '')
    {
        parse_str($params, $args);

        if (!empty($args['name'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('marque.name', ':name')
            )
            ->setParameter('name', $args['name']);
        }

        if (!empty($args['categorie'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('marque.categorie', ':categorie')
            )
            ->setParameter('categorie', $args['categorie']);
        }

        if (isset($args['isEnabled'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('marque.isEnabled', ':isEnabled')
            )
            ->setParameter('isEnabled', $args['isEnabled'], \PDO::PARAM_BOOL);
        }

        if (isset($args['deleted'])) {
            if ($args['deleted'] === 'true') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNotNull('marque.deletedAt')
                );
            } elseif ($args['deleted'] === 'false') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNull('marque.deletedAt')
                );
            }
        }

        if (!empty($args['orderby'])) {
            if (!empty($args['order'])) {
                $queryBuilder->orderby('marque' . $args['orderby'], $args['order']);
            } else {
                $queryBuilder->orderby('marque' . $args['orderby'], 'asc');
            }
        } else {
            $queryBuilder->orderby('marque.id', 'desc');
        }

        if (!empty($args['search'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('marque.id', ':searchInt'),
                    $queryBuilder->expr()->like('LOWER(marque.name)', ':search'),
                )
            );
            $queryBuilder->setParameter('search', '%' . strtolower($args['search']) . '%');
            $queryBuilder->setParameter('searchInt', (int) $args['search']);
        }
    }
}
