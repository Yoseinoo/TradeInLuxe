<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class MarqueFixtures extends Fixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['MarqueFixtures'];
    }

    public function load(ObjectManager $manager): void
    {
        // Ajouter des marques de luxe
        $this->addMarques($manager, [
            ['name' => 'Gucci'],
            ['name' => 'Louis Vuitton'],
            ['name' => 'Chanel'],
            ['name' => 'Hermès'],
            ['name' => 'Yves Saint Laurent'],
        ]);
    }
    
    // Fonction pour ajouter des marques
    private function addMarques(ObjectManager $manager, $marques)
    {
        foreach ($marques as $marqueData) {
            $marque = new Marque();
            $marque->setName($marqueData['name']);

            $manager->persist($marque);
        }

        $manager->flush();
    }
}
