<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use App\Entity\Mangashelf;
use App\Entity\Mangatheque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Member;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    private function membersGenerator()
    {
        yield ['olivier@localhost','123456'];
        yield ['slash@localhost','123456'];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        //Member
        $members = [];
        foreach ($this->membersGenerator() as [$email, $plainPassword]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);

            // $roles = array();
            // $roles[] = $role;
            // $user->setRoles($roles);

            $manager->persist($user);
            $members[] = $user;
        }
        
        $manager->flush(); 

        //Mangashelf
        $mangashelves = [];

        foreach ($members as $member) {
            $mangashelf = new Mangashelf();
            $mangashelf->setName($faker->word . ' Shelf');
            $mangashelf->setMembre($member); // Assign each Member a unique Mangashelf

            $manager->persist($mangashelf);
            $mangashelves[] = $mangashelf;
        }

        //Manga
        for ($i = 0; $i < 10; $i++) {
            $manga = new Manga();
            $manga->setName($faker->word); 
            $manga->setAuthor($faker->name); 

            //Association de chaque Manga à un Mangashelf aléatoire
            $randomMangashelf = $mangashelves[array_rand($mangashelves)];
            $manga->setMangashelf($randomMangashelf);

            $manager->persist($manga);
        }

        //Mangatheque
        for ($i = 0; $i < 5; $i++) {
            $mangatheque = new Mangatheque();
            $mangatheque->setDescription($faker->sentence);

            $mangatheque->setPubliee(true); 
            
            $manager->persist($mangatheque);
        }
        

        $manager->flush();
    }
}
