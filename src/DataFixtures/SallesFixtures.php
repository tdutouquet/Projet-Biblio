<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Salles;
use App\Entity\Equipements;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SallesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $equipements = $manager->getRepository(Equipements::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $salle = new Salles();
            $salle->setNom($faker->sentence(3));
            $salle->setCapacite($faker->numberBetween(1, 10));
            $salle->setDisponibilite($faker->boolean());
            $salle->setEmplacement($faker->numberBetween(1, 10));

            for ($j = 0; $j < 2; $j++) {
                $salle->addEquipement($equipements[array_rand($equipements)]);
            }
            $manager->persist($salle);
        }

        $manager->flush();
    }

    public function getDependencies()
    { 
        return [
            EquipementsFixtures::class,
        ];
    }
}
