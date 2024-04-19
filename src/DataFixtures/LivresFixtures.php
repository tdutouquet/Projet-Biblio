<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Livres;
use App\Entity\Etat;

class LivresFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $etats = $manager->getRepository(Etat::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $livre = new Livres();
            $livre->setTitre($faker->sentence(3));
            $livre->setAuteur($faker->name());
            $livre->setAnneePublication($faker->year());
            $livre->setMaisonEdition($faker->city());
            $livre->setResume($faker->text());
            $livre->setImage($faker->imageUrl());
            $livre->setCategorie($faker->word());
            $livre->setDisponibilite($faker->boolean(true));
            $livre->setNote($faker->numberBetween(0, 5));

            // Sélection aléatoire pour l'etat du livre
            $etat = $etats[array_rand($etats)];
            $livre->setEtat($etat);

            $manager->persist($livre);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
