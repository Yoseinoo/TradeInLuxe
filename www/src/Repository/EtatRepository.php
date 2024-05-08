<?php

namespace App\Repository;

use App\Entity\Etat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etat>
 *
 * @method Etat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etat[]    findAll()
 * @method Etat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etat::class);
    }

    public function save(Etat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOne($params = ''): ?Etat
    {
        $queryBuilder = $this->createQueryBuilder('etat');

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
        $queryBuilder = $this->createQueryBuilder('etat');

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
                $queryBuilder->expr()->eq('etat.name', ':name')
            )
            ->setParameter('name', $args['name']);
        }

        if (isset($args['isEnabled'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('etat.isEnabled', ':isEnabled')
            )
            ->setParameter('isEnabled', $args['isEnabled'], \PDO::PARAM_BOOL);
        }

        if (isset($args['deleted'])) {
            if ($args['deleted'] === 'true') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNotNull('etat.deletedAt')
                );
            } elseif ($args['deleted'] === 'false') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNull('etat.deletedAt')
                );
            }
        }

        if (!empty($args['orderby'])) {
            if (!empty($args['order'])) {
                $queryBuilder->orderby('etat.' . $args['orderby'], $args['order']);
            } else {
                $queryBuilder->orderby('etat.' . $args['orderby'], 'asc');
            }
        } else {
            $queryBuilder->orderby('etat.id', 'desc');
        }

        if (!empty($args['search'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('etat.id', ':searchInt'),
                    $queryBuilder->expr()->like('LOWER(etat.name)', ':search'),
                )
            );
            $queryBuilder->setParameter('search', '%' . strtolower($args['search']) . '%');
            $queryBuilder->setParameter('searchInt', (int) $args['search']);
        }
    }
}
