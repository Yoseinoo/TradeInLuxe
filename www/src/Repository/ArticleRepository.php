<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOne($params = ''): ?Article
    {
        $queryBuilder = $this->createQueryBuilder('article');

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
        $queryBuilder = $this->createQueryBuilder('article');

        $this->getParams($queryBuilder, $params);

        $query = $queryBuilder->getQuery();

        $query->useQueryCache(true);
        $query->enableResultCache();

        return $query->getResult();
    }

    public function getAllQueryBuilder($params = '', $filtres = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('article')
            ->select('article')
        ;

        $this->getParams($queryBuilder, $params, $filtres);

        return $queryBuilder;
    }

    private function getParams($queryBuilder, $params = '', $filtres = null)
    {
        parse_str($params, $args);

        if (!empty($args['name'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('article.name', ':name')
            )
            ->setParameter('name', $args['name']);
        }

        if (!empty($args['id'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('article.id', ':id')
            )
            ->setParameter('id', $args['id']);
        }

        if (!empty($filtres)) {

            $andConditions = [];

            foreach ($filtres as $type => $valeurs) {
                if ($type !== 'triProduits'){
                // Initialiser une liste de conditions pour les valeurs du filtre "OR" pour ce type
                $orConditions = [];

                foreach ($valeurs as $key => $valeur) {
                    if($key !== 'Etat'){
                         // Construire la condition "OR" pour chaque valeur de filtre
                        $orConditions[] = "article.caracteristiques LIKE :filtre_$type$key";
                        $queryBuilder->setParameter(":filtre_$type$key", '%"' . $valeur . '"%');
                    }else{
                        // Construire la condition "OR" pour chaque valeur de filtre
                        $orConditions[] = "article.etat LIKE :filtre_$type$key";
                        $queryBuilder->setParameter(":filtre_$type$key", '%"' . $valeur . '"%');
                    }
                   
                }

                // Combiner les conditions "OR" avec un "OR"
                $orCondition = implode(' OR ', $orConditions);

                // Ajouter la condition "OR" à la liste des conditions "AND"
                $andConditions[] = "($orCondition)";
            }
            }
            if (!empty($andConditions)){
                // Combiner toutes les conditions "AND" avec un "AND"
            $andCondition = implode(' AND ', $andConditions);

            // Ajouter la condition "AND" à la requête principale
            $queryBuilder->andWhere($andCondition);
            }
            
        }

        if (!empty($args['produit'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('article.produit', ':produit')
            )
            ->setParameter('produit', $args['produit']);
        }

        if (isset($args['isEnabled'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('article.isEnabled', ':isEnabled')
            )
            ->setParameter('isEnabled', $args['isEnabled'], \PDO::PARAM_BOOL);
        }

        if (isset($args['isValidated'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('article.isValidated', ':isValidated')
            )
            ->setParameter('isValidated', $args['isValidated'], \PDO::PARAM_BOOL);
        }

        if (isset($args['deleted'])) {
            if ($args['deleted'] === 'true') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNotNull('article.deletedAt')
                );
            } elseif ($args['deleted'] === 'false') {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->isNull('article.deletedAt')
                );
            }
        }

        if (!empty($args['orderby'])) {
            $direction = $args['order'] ?? 'asc'; 
            $queryBuilder->orderBy('article.' . $args['orderby'], $direction);
        }

        if (!empty($args['search'])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('article.id', ':searchInt'),
                    $queryBuilder->expr()->like('LOWER(article.name)', ':search'),
                )
            );
            $queryBuilder->setParameter('search', '%' . strtolower($args['search']) . '%');
            $queryBuilder->setParameter('searchInt', (int) $args['search']);
        }
    }

//    /**
//     * @return Article[] Returns an array of Article objects
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

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
