<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Subscription;
use App\Entity\SubscriptionType;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\SubscriptionTypeFixtures;

class SubscriptionFixtures extends Fixture
{
    public function getDependencies()
{
    return [
        UserFixtures::class,
        SubscriptionTypeFixtures::class,
    ];
}

    public function load(ObjectManager $manager): void
    {
        // $userReference = $this->getReference('user');
        // $subscriptionMonthlyReference = $this->getReference('subType-monthly');
        // $subscriptionYearlyReference = $this->getReference('subType-yearly');

        // // Yearly subscription
        // $subscription = new Subscription();
        // $subscription->setEndDate(new \DateTime('+1 year'));
        // $subscription->setSubscriptionType($subscriptionYearlyReference);
        // $subscription->setUser($userReference);

        // $manager->persist($subscription);

        // // Monthly subscription
        // $subscription = new Subscription();
        // $subscription->setEndDate(new \DateTime('+1 month'));
        // $subscription->setSubscriptionType($subscriptionMonthlyReference);
        // $subscription->setUser($userReference);

        // $manager->persist($subscription);

        // // Send the data to the database
        // $manager->flush();
    }
}
