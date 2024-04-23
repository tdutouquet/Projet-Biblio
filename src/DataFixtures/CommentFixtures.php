<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Livres;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create('fr_FR');
        $livres = $manager->getRepository(Livres::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 50; $i++) {
            $comment = new Comment();
            $comment->setUser($users[array_rand($users)]);
            $comment->setLivre($livres[array_rand($livres)]);
            $comment->setContent($faker->text());
            $comment->setRating($faker->numberBetween(0, 5));
            
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LivresFixtures::class,
            UserFixtures::class,
        ];
    }
}
