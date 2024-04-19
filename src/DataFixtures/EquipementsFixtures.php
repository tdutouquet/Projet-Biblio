<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Equipements;

class EquipementsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $equipements = ['Wi-Fi', 'Projecteur', 'Tableau', 'Prises Electriques', 'Télévision', 'Climatisation'];

        foreach ($equipements as $equipementsSalle) {
            $equipements = new Equipements();
            $equipements->setNom($equipementsSalle);
            $manager->persist($equipements);
        }

        
        $manager->flush();
    }
}
