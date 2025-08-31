<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Book;
use App\Entity\User;
use App\DataFixtures\UserFixtures;
use Faker\Factory;

class BookFixtures extends Fixture implements DependentFixtureInterface
{

    private $faker;
    private $users;

    public function __construct() {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $this->users = $manager->getRepository(User::class)->findAll();
        $this->generateBooks(50, $manager);
        $manager->flush();
    }

    // Generate a given number of books
    private function generateBooks(int $count, ObjectManager $manager)
    {
        for($i = 1; $i <= $count; $i++) {
            $book = (new Book())
                ->setTitle($this->faker->sentence(3))
                ->setSynopsis($this->faker->paragraph)
                ->setNbPages($this->faker->numberBetween(100, 500))
                ->setIsBorrowed($this->getRandomUser());
            $manager->persist($book);
        }
    }

    // Get a random user or null (50% chance)
    private function getRandomUser(): ?User
    {
        if($this->faker->boolean(50)) {
            return $this->users[array_rand($this->users)];
        }
        return null;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

}
