<?php

namespace App\DataFixtures;

use App\Entity\Couleur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CouleurFixtures extends Fixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['CouleurFixtures'];
    }

    public function load(ObjectManager $manager): void
    {
        // Ajouter des couleurs
        $this->addCouleurs($manager, [
            ['name' => 'Noir'],
            ['name' => 'Blanc'],
            ['name' => 'Bleu'],
            ['name' => 'Rouge'],
            ['name' => 'Vert'],
            ['name' => 'Jaune'],
            ['name' => 'Rose'],
            ['name' => 'Violet'],
            ['name' => 'Orange'],
            ['name' => 'Gris'],
            ['name' => 'Marron'],
            ['name' => 'Beige'],
            ['name' => 'Turquoise'],
        ]);
    }

    // Fonction pour ajouter des couleurs
    private function addCouleurs(ObjectManager $manager, $couleurs)
    {
        foreach ($couleurs as $couleurData) {
            $couleur = new Couleur();
            $couleur->setName($couleurData['name']);

            $manager->persist($couleur);
        }

        $manager->flush();
    }
}
