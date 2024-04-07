<?php

namespace App\Repository;

use App\Entity\SubjectContact;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<SubjectContact>
 *
 * @method SubjectContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectContact[]    findAll()
 * @method SubjectContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectContact::class);
    }

    public function save(SubjectContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function getOne($params = ''): ?SubjectContact
    {
        $queryBuilder = $this->createQueryBuilder('subjectContact');

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
        $queryBuilder = $this->createQueryBuilder('subjectContact');

        $this->getParams($queryBuilder, $params);

        $query = $queryBuilder->getQuery();

        $query->useQueryCache(true);
        $query->enableResultCache();

        return $query->getResult();
    }

    private function getParams($queryBuilder, $params = '')
    {
        parse_str($params, $args);

        if (!empty($args['sujet'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('subjectContact.sujet', ':sujet')
            )
            ->setParameter('sujet', $args['sujet']);
        }

        if (isset($args['isEnabled'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('subjectContact.isEnabled', ':isEnabled')
            )
            ->setParameter('isEnabled', $args['isEnabled'], \PDO::PARAM_BOOL);
        }

        if (isset($args['deleted'])) {
            if ($args['deleted'] === 'true') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNotNull('subjectContact.deletedAt')
                );
            } elseif ($args['deleted'] === 'false') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNull('subjectContact.deletedAt')
                );
            }
        }

        if (!empty($args['orderby'])) {
            $direction = $args['order'] ?? 'asc'; 
            $queryBuilder->orderBy('subjectContact.' . $args['orderby'], $direction);
        }

        if (!empty($args['search'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('subjectContact.id', ':searchInt'),
                    $queryBuilder->expr()->like('LOWER(subjectContact.sujet)', ':search'),
                    $queryBuilder->expr()->like('LOWER(subjectContact.email)', ':searchEmail'),
                )
            );
            $queryBuilder->setParameter('search', '%' . strtolower($args['search']) . '%');
            $queryBuilder->setParameter('searchInt', (int) $args['search']);
            $queryBuilder->setParameter('searchEmail', '%' . strtolower($args['search']) . '%');
        }
    }

//    /**
//     * @return SubjectContact[] Returns an array of SubjectContact objects
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

//    public function findOneBySomeField($value): ?SubjectContact
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
