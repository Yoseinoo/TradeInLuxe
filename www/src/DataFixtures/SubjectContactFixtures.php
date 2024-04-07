<?php

namespace App\DataFixtures;

use App\Entity\SubjectContact;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class SubjectContactFixtures extends Fixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['SubjectContactFixtures'];
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        // Définir les sujets
        $sujets = ['Échanges', 'Qualités', 'Authenticité', 'Autres'];

        foreach ($sujets as $sujet) {
            $subjectContact = new SubjectContact();
            $subjectContact->setSujet($sujet);
            // Générer un email factice pour chaque sujet
            $subjectContact->setEmail($faker->email);

            $manager->persist($subjectContact);
        }

        $manager->flush();
    }
}
