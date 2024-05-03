<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ZArticleFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private UserRepository $userRepository,
        private CategorieRepository $categorieRepository,
        private ProduitRepository $produitRepository
    ) {
    }

    public static function getGroups(): array
    {
        return ['ZArticleFixtures'];
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'martinsimongo@gmail.com']);
        $categorie = $this->categorieRepository->findOneBy(['name' => 'Chaussures']);
        $produit = $this->produitRepository->findOneBy(['name' => 'Sneaker LV Rush']);

        $articles = [
            [
                'name' => 'Sneaker LV Rush', 'description' => "Dévoilée lors du défilé Croisière 2024, cette sneaker LV Rush présente un mélange de matières dont du cuir de veau lisse et velours. Le directeur artistique, Nicolas Ghesquière, s'est inspiré des chaussures de trail pour la concevoir. Elle intègre parmi d'autres détails phares un accessoire LV Circle métallique et une semelle extérieure en forme de vague.", "image" => "rush1.avif", 'caracteristiques' => [
                    'Marque' => 'Louis Vuitton',
                    'Taille' => '36',
                    'Etat' => 'Neuf'
                ],
                'photos' => [
                    'rush1.avif', 'rush2.avif', 'rush3.avif', 'rush4.avif'
                ],
                'etat' => 'Neuf',
                'points' => 560
            ],
            [
                'name' => 'Sneaker LV Rush', 'description' => "Dévoilée lors du défilé Croisière 2024, cette sneaker LV Rush présente un mélange de matières dont du cuir de veau lisse et velours. Le directeur artistique, Nicolas Ghesquière, s'est inspiré des chaussures de trail pour la concevoir. Elle intègre parmi d'autres détails phares un accessoire LV Circle métallique et une semelle extérieure en forme de vague.", "image" => "rush1.avif", 'caracteristiques' => [
                    'Marque' => 'Louis Vuitton',
                    'Taille' => '36',
                    'Etat' => 'Neuf'
                ],
                'photos' => [
                    'rush1.avif', 'rush2.avif', 'rush3.avif', 'rush4.avif'
                ],
                'etat' => 'Très bon état',
                'points' => 360
            ]
        ];

        foreach ($articles as $article) {

            $entity = new Article();
            $entity->setUser($user);
            $entity->setCategorie($categorie);
            $entity->setProduit($produit);
            $entity->setName($article['name']);
            $entity->setDescription($article['description']);
            $entity->setCaracteristiques($article['caracteristiques']);
            $entity->setPathImage($article['image']);
            $entity->setPhotos($article['photos']);
            $entity->setEtat($article['etat']);
            $entity->setPoints($article['points']);
            $entity->setIsValidated(true);


            $manager->persist($entity);
        }
        
        $manager->flush();

    }
}
