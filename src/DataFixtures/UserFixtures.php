<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach ($this->getUserData() as [$email,$plainPassword,$role]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);
            
            $user->setName($faker->firstName);
            $user->setSurname($faker->lastName);

            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);

            $manager->persist($user);
            $members[] = $user;
        }
        $manager->flush();
    }
    private function getUserData()
    {
        yield [
            'chris@localhost',
            'chris',
            'ROLE_USER'
        ];
        yield [
            'anna@localhost',
            'anna',
            'ROLE_ADMIN'
        ];
    }
}
