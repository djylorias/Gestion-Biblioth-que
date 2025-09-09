<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Subscriber;
use Faker\Factory;

class SubscriberFixtures extends Fixture
{
    private $faker;
    private $subscribers;

    public function __construct() {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $subscribers = $manager->getRepository(Subscriber::class)->findAll();

        $subscriber = (new Subscriber())
            ->setFirstname('ludovic')
            ->setLastname('Bernard')
            ->setEmail('ludo.bernard59320@gmail.com');
        $manager->persist($subscriber);

        $this->generateSubscribers(5, $manager);

        $manager->flush();
    }

    // Generate a given number of subscribers
    private function generateSubscribers(int $count, ObjectManager $manager)
    {
        for ($i = 1; $i <= $count; $i++) {
            $subscriber = (new Subscriber())
                ->setFirstname($this->faker->firstName)
                ->setLastname($this->faker->lastName)
                ->setEmail($this->faker->email);
            $manager->persist($subscriber);
        }
    }

}
