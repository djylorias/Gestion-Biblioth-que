<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private $faker;
    private $users;

    public function __construct() {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();

        $user = (new User())
            ->setName('ludovic');
        $manager->persist($user);

        $this->generateUsers(5, $manager);

        $manager->flush();
    }

    // Generate a given number of users
    private function generateUsers(int $count, ObjectManager $manager)
    {
        for ($i = 1; $i <= $count; $i++) {
            $user = (new User())
                ->setName($this->faker->firstName);
            $manager->persist($user);
        }
    }

}
