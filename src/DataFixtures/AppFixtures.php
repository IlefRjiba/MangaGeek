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

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Genres de mangas pour les Mangashelves
        $mangashelfNames = [
            'Shōnen Action', 'Romance Shōjo', 'Seinen Dramatique',
            'Fantasy Épique', 'Mystère et Suspense', 'Comédie Slice of Life',
        ];

        // Thèmes ou collections pour les Mangathèques
        $mangathequeNames = [
            'Classiques du Manga', 'Mangas Récompensés', 
            'Nouveautés de la Semaine', 'Horreur et Paranormal',
            'Sci-Fi et Cyberpunk', 'Adaptations Anime',
        ];

        // Noms de mangas inspirés
        $mangaNames = [
            'L’Attaque des Titans', 'One Piece', 'Naruto',
            'Demon Slayer', 'Jujutsu Kaisen', 'Tokyo Revengers',
            'Death Note', 'Fullmetal Alchemist', 'Hunter x Hunter',
            'My Hero Academia', 'Sword Art Online', 'Fairy Tail',
            'Black Clover', 'Bleach', 'Chainsaw Man',
        ];

        $mangaData = [
            ['name' => 'Demon Slayer', 'image' => 'demon_slayer.jpg'],
            ['name' => 'Jujutsu Kaisen', 'image' => 'jujutsu_kaisen.jpg'],
            ['name' => 'One Piece', 'image' => 'one_piece.jpg'],
            ['name' => 'Naruto', 'image' => 'naruto.jpg'],
            ['name' => 'Tokyo Revengers', 'image' => 'tokyo_revengers.jpg'],
            ['name' => 'Death Note', 'image' => 'death_note.jpg'],
            ['name' => 'Fullmetal Alchemist', 'image' => 'fullmetal_alchemist.jpg'],
            ['name' => 'Hunter x Hunter', 'image' => 'hunter_x_hunter.jpg'],
            ['name' => 'My Hero Academia', 'image' => 'my_hero_academia.jpg'],
            ['name' => 'Sword Art Online', 'image' => 'sword_art_online.jpg'],
        ];

        // Récupérer tous les membres créés par UserFixtures
        $members = $manager->getRepository(Member::class)->findAll();
        if (empty($members)) {
            throw new \Exception("Aucun membre trouvé. Assurez-vous que UserFixtures charge correctement les membres.");
        }

        // Création des Mangashelves
        $mangashelves = [];
        foreach ($members as $member) {
            $name = $faker->randomElement($mangashelfNames);
            $mangashelf = new Mangashelf();
            $mangashelf->setName($name . " de " . $member->getName());
            $mangashelf->setMembre($member);

            $manager->persist($mangashelf);
            $mangashelves[] = $mangashelf;
        }

        // Création des Mangathèques
        $mangatheques = [];
        foreach ($members as $member) {
            for ($i = 0; $i < 2; $i++) {
                $name = $faker->randomElement($mangathequeNames);
                $mangatheque = new Mangatheque();
                $mangatheque->setName($name);
                $mangatheque->setDescription($faker->sentence(8));
                $mangatheque->setPubliee($faker->boolean(80)); // 80% de chance d’être publiée
                $mangatheque->setMember($member);

                $manager->persist($mangatheque);
                $mangatheques[] = $mangatheque;
            }
        }

        // Création des Mangas
        foreach ($mangaNames as $name) {
            $manga = new Manga();
            $manga->setName($name);
            $manga->setAuthor($faker->name());

            // Associer chaque Manga à un Mangashelf aléatoire
            $randomMangashelf = $faker->randomElement($mangashelves);
            $manga->setMangashelf($randomMangashelf);

            // Associer chaque Manga à un ou plusieurs Mangathèques aléatoires
            $randomMangatheques = $faker->randomElements($mangatheques, rand(1, 3));
            foreach ($randomMangatheques as $mangatheque) {
                $manga->addMangatheque($mangatheque);
            }

            $manager->persist($manga);
        }

        $manager->flush();
    }
}
