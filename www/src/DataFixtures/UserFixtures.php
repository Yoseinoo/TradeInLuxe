<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['UserFixtures'];
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Moi
        $user = new User;
            $user->setEmail('martinsimongo@gmail.com')
            ->setFirstname('Martin')
            ->setLastname('Simon')
            ->setIsVerified(true)
            ->setPlainPassword('password');

            $manager->persist($user);

        // Fake user
        for ($i=0; $i<=5; $i++){
            $user = new User;
            $user->setEmail($faker->email())
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setIsVerified(true)
            ->setPlainPassword('password');

            $manager->persist($user);
        }

        $manager->flush();
    }
}
