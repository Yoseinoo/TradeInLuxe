<?php

namespace App\DataFixtures;

use App\Entity\Image;
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
                ['name' => 'Chaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg"],
            ],
            'Sacs' => [
                ['name' => 'Sac CarryAll PM', 'description' => "Pièce chic et confortable réalisée en toile Monogram avec une garniture en cuir naturel, ce sac CarryAll PM s'emporte partout. Son intérieur spacieux et bien pensé comporte deux grandes poches intérieures pour une organisation optimale. Également en toile Monogram, une pochette amovible munie d'une fermeture à glissière est attachée au sac par un lacet en cuir.", "image" => "build/images/accueil/sacCategorie.png"],
            ],
            'Vêtements' => [
                ['name' => 'Cardigan brodé en coton', 'description' => "Présenté lors du défilé Printemps-Été 2024, ce cardigan marron en coton s'agrémente de portraits de Henry Taylor brodés sur une maille fine rehaussée de LV contrastés. Des boutons perle offrent un esprit tailoring à cette pièce sophistiquée qui peut s'associer aux modèles habillés de la collection ornés du même motif.", "image" => "build/images/uploads/vetements/cardigan.png"],
            ],
        ];

        foreach ($produits as $categorie => $items) {
            foreach ($items as $item) {
                $image = new Image();
                $image->setPath($item['image']);

                $entity = new Produit();
                $entity->setCategorie($this->categorieRepository->getOne('name='. $categorie));
                $entity->setName($item['name']);
                $entity->setDescription($item['description']);
                $entity->setImage($image);

                $manager->persist($image);

                $manager->persist($entity);
            }
        }

        $manager->flush();
    }
}
