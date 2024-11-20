<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use App\Entity\Mangashelf;
use App\Entity\Mangatheque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Préparer les chemins des images
        $imagePath = __DIR__ . '/../../public/uploads/mangas';
        $imageMapping = [
            'L’Attaque des Titans' => 'aot.png',
            'Black Clover' => 'black clover.jpg',
            'Bleach' => 'bleach.jpg',
            'Chainsaw Man' => 'chainsaw.jpg',
            'Death Note' => 'deathNote.jpg',
            'Fairy Tail' => 'fairytail.jpg',
            'Fullmetal Alchemist' => 'fmalchemist.jpg',
            'Hunter x Hunter' => 'hxh.jpg',
            'Jujutsu Kaisen' => 'jjk.jpg',
            'Demon Slayer' => 'kny.jpg',
            'My Hero Academia' => 'mha.jpg',
            'Naruto' => 'naruto.jpg',
            'One Piece' => 'one piece.jpg',
            'Sword Art Online' => 'swa.jpg',
            'Tokyo Revengers' => 'tokyo-revengers.jpg',
        ];

        // Thèmes ou collections pour les Mangathèques
        $mangathequeData = [
            'Shōnen Épique' => [
                "description" => "Un lieu où l'on revit les batailles épiques des plus grands héros. Chaque étagère raconte une histoire de courage, d'amitié et de dépassement de soi.",
                "mangas" => [
                    'L’Attaque des Titans', 'My Hero Academia', 'One Piece', 'Naruto',
                ],
            ],
            'Seinen Dramatique' => [
                "description" => "Une collection sombre et intense pour les amateurs de récits profonds et réalistes qui explorent les émotions humaines.",
                "mangas" => [
                    'Death Note', 'Tokyo Revengers', 'Jujutsu Kaisen', 'Chainsaw Man',
                ],
            ],
            'Fantasy Épique' => [
                "description" => "Traversez des mondes magiques où dragons, chevaliers et quêtes épiques prennent vie.",
                "mangas" => [
                    'Fairy Tail', 'Black Clover', 'Bleach', 'Demon Slayer',
                ],
            ],
            'Horreur et Suspense' => [
                "description" => "Un espace mystérieux où chaque recoin est rempli de récits qui vous tiendront éveillés toute la nuit.",
                "mangas" => [
                    'Chainsaw Man', 'Death Note', 'Jujutsu Kaisen',
                ],
            ],
            'Science-fiction et Cyberpunk' => [
                "description" => "Un univers futuriste où la technologie et l'imagination ne connaissent pas de limites.",
                "mangas" => [
                    'Sword Art Online', 'Hunter x Hunter', 'Fullmetal Alchemist',
                ],
            ],
        ];

        // Récupérer tous les membres créés par UserFixtures
        $members = $manager->getRepository(\App\Entity\Member::class)->findAll();
        if (empty($members)) {
            throw new \Exception("Aucun membre trouvé. Assurez-vous que UserFixtures charge correctement les membres.");
        }

        // Création des Mangashelves
        $mangashelves = [];
        foreach ($members as $member) {
            $mangashelf = new Mangashelf();
            $mangashelf->setName("Collection de " . $member->getName());
            $mangashelf->setMembre($member);

            $manager->persist($mangashelf);
            $mangashelves[] = $mangashelf;
        }

        // Création des Mangathèques - Chaque membre a une Mangathèque
        $mangatheques = [];
        foreach ($mangathequeData as $mangathequeName => $data) {
            $member = $faker->randomElement($members);
            $mangatheque = new Mangatheque();
            $mangatheque->setName($mangathequeName);
            $mangatheque->setDescription($data['description']);
            $mangatheque->setPubliee($faker->boolean(80));
            $mangatheque->setMember($member);

            $manager->persist($mangatheque);
            $mangatheques[$mangathequeName] = $mangatheque;
        }

        // Création des Mangas avec images
        foreach ($imageMapping as $mangaName => $filename) {
            $manga = new Manga();
            $manga->setName($mangaName);
            $manga->setAuthor($faker->name());

            // Associer le Manga à un Mangashelf aléatoire
            $randomMangashelf = $faker->randomElement($mangashelves);
            $manga->setMangashelf($randomMangashelf);

            // Associer le Manga à une ou plusieurs Mangathèques spécifiques au thème
            foreach ($mangathequeData as $mangathequeName => $data) {
                if (in_array($mangaName, $data['mangas'])) {
                    $manga->addMangatheque($mangatheques[$mangathequeName]);
                }
            }

            // Ajouter l'image associée
            $imageFilePath = $imagePath . '/' . $filename;
            if (file_exists($imageFilePath)) {
                $manga->setImageFile(new File($imageFilePath));
                $manga->setImageName($filename);
            } else {
                throw new \Exception("Fichier image non trouvé : $imageFilePath");
            }

            $manager->persist($manga);
        }

        $manager->flush();
    }
}
