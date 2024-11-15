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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
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

    public function getDependencies()
        {
                return [
                        UserFixtures::class,
                ];
        }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        //Mangashelf
        $mangashelves = [];

        foreach (self::MangashelfDataGenerator() as [$name, $memberemail] ) {
                $mangashelf = new Mangashelf();
                if ($memberemail) {
                        $member = $manager->getRepository(Mangashelf::class)->findOneByEmail($memberemail);
                        $mangashelf->setMembre($member);
                }
                $mangashelf->setName($name);
                $manager->persist($mangashelf);
        }
        $manager->flush();
        
        

        // foreach ($members as $member) {
        //     $mangashelf = new Mangashelf();
        //     $mangashelf->setName($faker->word . ' Shelf');
        //     // Assign each Member a unique Mangashelf
        //     $mangashelf->setMembre($member);

        //     $manager->persist($mangashelf);
        //     $mangashelves[] = $mangashelf;
        // }

        //Mangatheque
        $mangatheques=[];
        for ($i = 0; $i < 5; $i++) {
            $mangatheque = new Mangatheque();
            $mangatheque->setName($faker->word . ' Mangatheque');
            $mangatheque->setDescription($faker->sentence);

            $mangatheque->setPubliee(true);
            
            $randomMember = $members[array_rand($members)];
            $mangatheque->setMember($randomMember);
            
            $manager->persist($mangatheque);
            $mangatheques[] = $mangatheque;
        }
        

        //Manga
        for ($i = 0; $i < 10; $i++) {
            $manga = new Manga();
            $manga->setName($faker->word); 
            $manga->setAuthor($faker->name); 

            //Association de chaque Manga à un Mangashelf aléatoire
            $randomMangashelf = $mangashelves[array_rand($mangashelves)];
            $manga->setMangashelf($randomMangashelf);

            //Association de chaque Manga à un ou plusieurs Mangatheque(s) aléatoire(s)
            $randomMangatheques = $faker->randomElements($mangatheques, rand(1, 3));
            foreach ($randomMangatheques as $mangatheque) {
                $manga->addMangatheque($mangatheque);  // Assuming addMangatheque() method exists in Manga
            }

            $manager->persist($manga);
        }


        $manager->flush();
    }
}
