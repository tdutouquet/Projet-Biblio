<?php

namespace App\DataFixtures;

use App\Entity\SubscribtionType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubscriptionTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1st type of subscribtion (monthly)
        $subType = new SubscribtionType();
        $subType->setName('Mensuel');
        $subType->setPrice(23.99);

        $manager->persist($subType);

        // 2nd type of subscribtion (yearly)
        $subType = new SubscribtionType();
        $subType->setName('Annuel');
        $subType->setPrice(259.99);

        $manager->persist($subType);

        $manager->flush();
    }
}
