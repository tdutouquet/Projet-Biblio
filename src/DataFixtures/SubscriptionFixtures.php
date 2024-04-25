<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Subscription;
use App\Entity\SubscriptionType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SubscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $subTypes = $manager->getRepository(SubscriptionType::class)->findAll();

        // 1st type of subscription (monthly)
        for ($i = 0; $i < 5; $i++) {
            $sub = new Subscription();
            $sub->setStartDate(new \DateTime('2021-01-01'));
            $sub->setEndDate(new \DateTime('2021-02-01'));
            $sub->setUser($users[array_rand($users)]);
            $sub->setSubscriptionType($subTypes[0]);
            $manager->persist($sub);
        }

        // 2nd type of subscription (yearly)
        for ($i = 0; $i < 5; $i++) {
            $sub = new Subscription();
            $sub->setStartDate(new \DateTime('2021-01-01'));
            $sub->setEndDate(new \DateTime('2022-01-01'));
            $sub->setUser($users[array_rand($users)]);
            $sub->setSubscriptionType($subTypes[1]);
            $manager->persist($sub);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SubscriptionTypeFixtures::class,
        ];
    }
}
