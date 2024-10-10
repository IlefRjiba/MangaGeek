<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use App\Entity\Mangashelf;
use App\Entity\Mangatheque;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création de Mangashelf
        $mangashelves = [];
        for ($i = 0; $i < 10; $i++) {
            $mangashelf = new Mangashelf();
            $mangashelf->setName($faker->word . ' Shelf'); 

            $manager->persist($mangashelf);
            $mangashelves[] = $mangashelf;  // Sauvegarder les étagères pour les utiliser plus tard
        }

        // Création de Manga et association à Mangashelf
        for ($i = 0; $i < 10; $i++) {
            $manga = new Manga();
            $manga->setName($faker->word); 
            $manga->setAuthor($faker->name); 

            // Associer chaque Manga à un Mangashelf aléatoire
            $randomMangashelf = $mangashelves[array_rand($mangashelves)];
            $manga->setMangashelf($randomMangashelf);

            $manager->persist($manga);
        }

        // Création de Mangatheque
        for ($i = 0; $i < 5; $i++) {
            $mangatheque = new Mangatheque();
            
            $manager->persist($mangatheque);
        }

        // Création de User
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName); 
            $user->setMdp($faker->password);  
            $user->setEmail($faker->email); 

            $manager->persist($user);
        }

        $manager->flush();
    }
}
