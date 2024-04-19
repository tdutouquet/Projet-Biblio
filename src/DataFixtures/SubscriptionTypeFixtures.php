<?php

namespace App\DataFixtures;

use App\Entity\SubscriptionType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubscriptionTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1st type of subscribtion (monthly)
        $subType = new SubscriptionType();
        $subType->setName('Mensuel');
        $subType->setPrice(23.99);

        $manager->persist($subType);

        $this->addReference('subType-monthly', $subType);

        // 2nd type of subscribtion (yearly)
        $subType = new SubscriptionType();
        $subType->setName('Annuel');
        $subType->setPrice(259.99);

        $manager->persist($subType);

        $this->addReference('subType-yearly', $subType);

        // Send the data to the database
        $manager->flush();
    }
}
