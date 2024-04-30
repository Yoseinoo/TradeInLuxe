<?php

namespace App\Repository;

use App\Entity\Couleur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Couleur>
 *
 * @method Couleur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Couleur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Couleur[]    findAll()
 * @method Couleur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouleurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Couleur::class);
    }

    public function save(Couleur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOne($params = ''): ?Couleur
    {
        $queryBuilder = $this->createQueryBuilder('couleur');

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
        $queryBuilder = $this->createQueryBuilder('couleur');

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
                $queryBuilder->expr()->eq('couleur.name', ':name')
            )
            ->setParameter('name', $args['name']);
        }

        if (isset($args['isEnabled'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('couleur.isEnabled', ':isEnabled')
            )
            ->setParameter('isEnabled', $args['isEnabled'], \PDO::PARAM_BOOL);
        }

        if (isset($args['deleted'])) {
            if ($args['deleted'] === 'true') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNotNull('couleur.deletedAt')
                );
            } elseif ($args['deleted'] === 'false') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNull('couleur.deletedAt')
                );
            }
        }

        if (!empty($args['orderby'])) {
            if (!empty($args['order'])) {
                $queryBuilder->orderby('couleur' . $args['orderby'], $args['order']);
            } else {
                $queryBuilder->orderby('couleur' . $args['orderby'], 'asc');
            }
        } else {
            $queryBuilder->orderby('couleur.id', 'desc');
        }

        if (!empty($args['search'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('couleur.id', ':searchInt'),
                    $queryBuilder->expr()->like('LOWER(couleur.name)', ':search'),
                )
            );
            $queryBuilder->setParameter('search', '%' . strtolower($args['search']) . '%');
            $queryBuilder->setParameter('searchInt', (int) $args['search']);
        }
    }
}
