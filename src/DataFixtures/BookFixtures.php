<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Book;
use App\Entity\Subscriber;
use App\DataFixtures\SubscriberFixtures;
use Faker\Factory;

class BookFixtures extends Fixture implements DependentFixtureInterface
{

    private const BOOK_FIXTURES_QUANTITY = 50;

    private $faker;
    private $subscribers;

    public function __construct() {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $this->subscribers = $manager->getRepository(Subscriber::class)->findAll();
        $this->generateBooks(self::BOOK_FIXTURES_QUANTITY, $manager);
        $manager->flush();
    }

    // Generate a given number of books
    private function generateBooks(int $count, ObjectManager $manager)
    {
        for($i = 1; $i <= $count; $i++) {
            $book = (new Book())
                ->setTitle($this->faker->sentence(3))
                ->setAuthor($this->faker->name)
                ->setSynopsis($this->faker->paragraph)
                ->setNbPages($this->faker->numberBetween(100, 500))
                ->setIsBorrowed($this->getRandomSubscriber());
            $manager->persist($book);
        }
    }

    // Get a random subscriber or null (50% chance)
    private function getRandomSubscriber(): ?Subscriber
    {
        if($this->faker->boolean(50)) {
            return $this->subscribers[array_rand($this->subscribers)];
        }
        return null;
    }

    public function getDependencies(): array
    {
        return [
            SubscriberFixtures::class,
        ];
    }

}
