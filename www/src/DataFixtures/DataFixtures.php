<?php

namespace App\DataFixtures;

use App\Entity\Taille;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class DataFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private CategorieRepository $categorieRepository
    ) {
    }

    public static function getGroups(): array
    {
        return ['DataFixtures'];
    }
    
    public function load(ObjectManager $manager): void
    {
        
        // Définir les catégories
        $categories = ['Chaussures' => 'La collection de chaussures propose des bottes, ballerines, chaussures à talon, mocassins, chaussures oxford, sandales et claquettes. Les chaussures sont proposées par des marques de créateurs telles que Balenciaga, Prada, Hermès, Louis Vuitton, Timberland, Versace, Crocs, Birkenstock, Chanel, Dior, Gucci et Dr. Martens. La collection de chaussures comprend des chaussures de course, des chaussures de golf, des bottes de randonnée, des chaussures de football et des chaussures de basketball. Les chaussures sont fabriquées à partir de matériaux tels que le cuir, le caoutchouc, les textiles, les matériaux synthétiques et la mousse. Les chaussures sont disponibles dans divers coloris et designs.',
         'Sacs' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
         'Vêtements' => 'De Supreme, Nike, adidas, et Travis Scott à Bape et Fear of God, il existe divers vêtements disponibles pour tous. Il y a des tenues de créateurs et des looks streetwear disponibles pour tous les âges et tous les genres. Nous offrons un peu de tout, des pulls en cachemire neufs ou d’occasion aux pantalons de créateurs, robes, costumes, sweat-shirts et bien plus encore. Des options de vêtements intemporels et tendance sont également disponibles auprès d’autres marques, telles que Supreme, North Face, Nike et adidas.'];

        foreach ($categories as $categorie => $description) {
            $entity = new Categorie();
            $entity->setName($categorie);
            $entity->setDescription($description);

            $manager->persist($entity);
        }
        
        $manager->flush();

        $produits = [
            'Chaussures' => [
                ['name' => 'Ahaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Gucci',
                'Taille' => '36',
                'Couleur' => 'Noir',
                'Genre' => 'Homme'
            ]],
                ['name' => 'Bhaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Gucci',
                'Taille' => '36',
                'Couleur' => 'Noir',
                'Genre' => 'Homme'
            ]],
                ['name' => 'Chaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Gucci',
                'Taille' => '36',
                'Couleur' => 'Noir',
                'Genre' => 'Homme'
            ]],
                ['name' => 'Dhaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Gucci',
                'Taille' => '36',
                'Couleur' => 'Noir',
                'Genre' => 'Homme'
            ]],
                ['name' => 'Ehaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Gucci',
                'Taille' => '36',
                'Couleur' => 'Noir',
                'Genre' => 'Homme'
            ]],
                ['name' => 'Fhaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Gucci',
                'Taille' => '36',
                'Couleur' => 'Noir',
                'Genre' => 'Homme'
            ]],
                ['name' => 'Fhaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Louis Vuitton',
                'Taille' => '36',
                'Couleur' => 'Noir',
                'Genre' => 'Homme'
            ]],
                ['name' => 'Ghaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Louis Vuitton',
                'Taille' => '36',
                'Couleur' => 'Beige',
                'Genre' => 'Femme'
            ]],
                ['name' => 'Hhaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Louis Vuitton',
                'Taille' => '36',
                'Couleur' => 'Beige',
                'Genre' => 'Femme'
            ]],
                ['name' => 'Chaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Louis Vuitton',
                'Taille' => '38',
                'Couleur' => 'Beige',
                'Genre' => 'Femme'
            ]],
                ['name' => 'Chaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Hermès',
                'Taille' => '38',
                'Couleur' => 'Beige',
                'Genre' => 'Femme'
            ]],
                ['name' => 'Chaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Louis Vuitton',
                'Taille' => '41',
                'Couleur' => 'Beige',
                'Genre' => 'Femme'
            ]],
                ['name' => 'Chaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Chanel',
                'Taille' => '38',
                'Couleur' => 'Beige',
                'Genre' => 'Femme'
            ]],
                ['name' => 'Chaussures Opyum Sandales en cuir verni', 'description' => "SANDALES À TALON CASSANDRE, MUNIES D'UNE BRIDE AJUSTABLE À LA CHEVILLE.", "image" => "build/images/accueil/chaussures.jpg",'caracteristiques' => [
                'Marque' => 'Chanel',
                'Taille' => '38',
                'Couleur' => 'Jaune',
                'Genre' => 'Autres'
            ]],
            ],
            'Sacs' => [
                ['name' => 'Sac CarryAll PM', 'description' => "Pièce chic et confortable réalisée en toile Monogram avec une garniture en cuir naturel, ce sac CarryAll PM s'emporte partout. Son intérieur spacieux et bien pensé comporte deux grandes poches intérieures pour une organisation optimale. Également en toile Monogram, une pochette amovible munie d'une fermeture à glissière est attachée au sac par un lacet en cuir.", "image" => "build/images/accueil/sacCategorie.png", 'caracteristiques' => [
                'Marque' => 'Louis Vuitton',
                'Taille' => 'S',
                'Couleur' => 'Blanc',
                'Genre' => 'Femme'
            ]],
            ],
            'Vêtements' => [
                ['name' => 'Cardigan brodé en coton', 'description' => "Présenté lors du défilé Printemps-Été 2024, ce cardigan marron en coton s'agrémente de portraits de Henry Taylor brodés sur une maille fine rehaussée de LV contrastés. Des boutons perle offrent un esprit tailoring à cette pièce sophistiquée qui peut s'associer aux modèles habillés de la collection ornés du même motif.", "image" => "build/images/uploads/vetements/cardigan.png", 'caracteristiques' => [
                'Marque' => 'Louis Vuitton',
                'Taille' => 'S',
                'Couleur' => 'Blanc',
                'Genre' => 'Femme'
            ]],
            ],
        ];

        foreach ($produits as $categorie => $items) {
            foreach ($items as $item) {

                $entity = new Produit();
                $entity->setCategorie($this->categorieRepository->getOne('name='. $categorie));
                $entity->setName($item['name']);
                $entity->setDescription($item['description']);
                $entity->setCaracteristiques($item['caracteristiques']);
                $entity->setPathImage($item['image']);

                $manager->persist($entity);
            }
        }

        $manager->flush();

         // Récupérer les catégories
         $sacsCategorie = $this->categorieRepository->findOneBy(['name' => 'Sacs']);
         $vetementsCategorie = $this->categorieRepository->findOneBy(['name' => 'Vêtements']);
         $chaussuresCategorie = $this->categorieRepository->findOneBy(['name' => 'Chaussures']);

        // Ajouter des filtres pour les sacs
        $this->addTailles($manager, $sacsCategorie, [
            ['name' => 'S', 'rank' => 1],
            ['name' => 'M', 'rank' => 2],
            ['name' => 'L', 'rank' => 3],
            
        ]);

        // Ajouter des filtres pour les vêtements
        $this->addTailles($manager, $vetementsCategorie, [
            ['name' => 'XXS', 'rank' => 1],
            ['name' => 'XS', 'rank' => 2],
            ['name' => 'S', 'rank' => 3],
            ['name' => 'M', 'rank' => 4],
            ['name' => 'L', 'rank' => 5],
            ['name' => 'XL', 'rank' => 6],
            ['name' => 'XXL', 'rank' => 7],
        ]);

        // Ajouter des filtres pour les chaussures
        $this->addTailles($manager, $chaussuresCategorie, [
            ['name' => '36', 'rank' => 1],
            ['name' => '37', 'rank' => 2],
            ['name' => '38', 'rank' => 3],
            ['name' => '39', 'rank' => 4],
            ['name' => '40', 'rank' => 5],
            ['name' => '41', 'rank' => 6],
            ['name' => '42', 'rank' => 7],
            ['name' => '43', 'rank' => 8],
        ]);
    }

    private function addTailles(ObjectManager $manager, $categorie, $filtres)
    {
        foreach ($filtres as $filtreData) {
            $filtre = new Taille();
            $filtre->setCategorie($categorie);
            $filtre->setName($filtreData['name']);
            $filtre->setRank($filtreData['rank']);

            $manager->persist($filtre);
        }

        $manager->flush();
    }
}
