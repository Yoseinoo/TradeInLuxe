<?php

namespace App\Repository;

use App\Entity\Taille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Taille>
 *
 * @method Taille|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taille|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taille[]    findAll()
 * @method Taille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TailleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Taille::class);
    }

    public function save(Taille $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOne($params = ''): ?Taille
    {
        $queryBuilder = $this->createQueryBuilder('taille');

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
        $queryBuilder = $this->createQueryBuilder('taille');

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
                $queryBuilder->expr()->eq('taille.name', ':name')
            )
            ->setParameter('name', $args['name']);
        }

        if (!empty($args['categorie'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('taille.categorie', ':categorie')
            )
            ->setParameter('categorie', $args['categorie']);
        }

        if (isset($args['isEnabled'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('taille.isEnabled', ':isEnabled')
            )
            ->setParameter('isEnabled', $args['isEnabled'], \PDO::PARAM_BOOL);
        }

        if (isset($args['deleted'])) {
            if ($args['deleted'] === 'true') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNotNull('taille.deletedAt')
                );
            } elseif ($args['deleted'] === 'false') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNull('taille.deletedAt')
                );
            }
        }

        if (!empty($args['orderby'])) {
            if (!empty($args['order'])) {
                $queryBuilder->orderby('taille.' . $args['orderby'], $args['order']);
            } else {
                $queryBuilder->orderby('taille.' . $args['orderby'], 'asc');
            }
        } else {
            $queryBuilder->orderby('taille.id', 'desc');
        }

        if (!empty($args['search'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('taille.id', ':searchInt'),
                    $queryBuilder->expr()->like('LOWER(taille.name)', ':search'),
                )
            );
            $queryBuilder->setParameter('search', '%' . strtolower($args['search']) . '%');
            $queryBuilder->setParameter('searchInt', (int) $args['search']);
        }
    }
}
