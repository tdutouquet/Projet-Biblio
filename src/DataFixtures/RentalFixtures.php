<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Rental;
use App\Entity\Salles;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RentalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $rooms = $manager->getRepository(Salles::class)->findAll();
 
        // Default rental for admin
        $rental = new Rental();
        $rental->setEndDate(new \DateTime('+2 hour'));
        $rental->setUser($users[0]);
        $rental->setRoom($rooms[array_rand($rooms)]);
        $manager->persist($rental);

        // 10 random rentals
        for ($i = 0; $i < 10; $i++) {
            $rental = new Rental();
            $rental->setEndDate(new \DateTime('+2 hour'));
            $rental->setUser($users[array_rand($users)]);
            $rental->setRoom($rooms[array_rand($rooms)]);
            $manager->persist($rental);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SallesFixtures::class,
        ];
    }
}
