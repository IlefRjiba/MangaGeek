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

        for ($i = 0; $i < 10; $i++) {
            $manga = new Manga();
            $manga->setName($faker->word); 
            $manga->setAuthor($faker->name); 

            $manager->persist($manga);
        }

        for ($i = 0; $i < 10; $i++) {
            $mangashelf = new Mangashelf();
            $mangashelf->setName($faker->word . ' Shelf'); 

            $manager->persist($mangashelf);
        }

        for ($i = 0; $i < 5; $i++) {
            $mangatheque = new Mangatheque();
            
            $manager->persist($mangatheque);
        }

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
