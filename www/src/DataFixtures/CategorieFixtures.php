<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CategorieFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private CategorieRepository $categorieRepository
    ) {
    }

    public static function getGroups(): array
    {
        return ['CategorieFixtures'];
    }
    
    public function load(ObjectManager $manager): void
    {
        
        // Définir les catégories
        $categories = ['Chaussures', 'Sacs', 'Vêtements'];

        foreach ($categories as $categorie) {
            $entity = new Categorie();
            $entity->setName($categorie);

            $manager->persist($entity);
        }
        
        $manager->flush();

        $produits = [
            'Chaussures' => [
                ['name' => 'Sneakers Balenciaga Triple S', 'description' => 'Sneakers emblématiques de la marque de luxe Balenciaga, avec une semelle imposante et un design avant-gardiste.'],
                ['name' => 'Chaussures à lacets Louis Vuitton', 'description' => 'Chaussures à lacets élégantes de la maison de couture Louis Vuitton, fabriquées en cuir de veau lisse de qualité supérieure.'],
            ],
            'Sacs' => [
                ['name' => 'Sac à dos Gucci GG Supreme', 'description' => 'Sac à dos GG Supreme de Gucci, avec motif monogramme et détails en cuir. Un accessoire de mode emblématique.'],
            ],
            'Vêtements' => [
                ['name' => 'Veste en cuir Saint Laurent', 'description' => 'Veste en cuir de la marque Saint Laurent, avec une silhouette classique et des finitions de qualité supérieure.'],
            ],
        ];

        foreach ($produits as $categorie => $items) {
            foreach ($items as $item) {
                $entity = new Produit();
                $entity->setCategorie($this->categorieRepository->getOne('name='. $categorie));
                $entity->setName($item['name']);
                $entity->setDescription($item['description']);

                $manager->persist($entity);
            }
        }

        $manager->flush();
    }
}
