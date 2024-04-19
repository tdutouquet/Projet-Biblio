<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {}


    public function load(ObjectManager $manager): void
    {
        // Admin user
        $admin = new User();
        $admin->setEmail('admin@localhost.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin,'admin')
        );
        $admin->setLastname('Didier');
        $admin->setFirstname('Jambono');
        $admin->setAddress('1 rue des champs');
        $admin->setZipcode('75000');
        $admin->setCity('Paris');
        $admin->setPhone('0600000000');
        $admin->setBirthdate(new \DateTime('1990-01-01'));

        $manager->persist($admin);

        // Fake users
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user,'unknown')
            );
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ', '', $faker->postcode));
            $user->setCity($faker->city);
            $user->setPhone(
                str_replace([' ', '+33', '0(0)'], ['', '0', '0'], $faker->phoneNumber)
            );
            $user->setBirthdate($faker->dateTimeBetween('-80 years', '-18 years'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
