<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etat;

class EtatsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $etats = ['Excellent état', 'Bon état', 'Etat moyen', 'Mauvais état'];

        foreach ($etats as $etatLivre) {
            $etat = new Etat();
            $etat->setNom($etatLivre);
            $manager->persist($etat);
        }

        $manager->flush();
    }
}
