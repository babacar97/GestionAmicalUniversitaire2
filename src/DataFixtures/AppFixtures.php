<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("fr_FR");

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setPassword($faker->password())
                ->setNom($faker->firstName())
                ->setPrenom($faker->lastName())
                ->setAdresse($faker->address())
                ->setNumeroTelephone($faker->e164PhoneNumber())
                ->setLieuNaissance($faker->company())
                ->setNumeroCarteIdentite($faker->isbn13())
                ->setNumeroCarteEtudiant($faker->isbn13())
                ->setFaculte($faker->city())
                ->setNiveauEtude($faker->city())
                ->setCodification($faker->boolean())
                ->setImage($faker->imageUrl())
                ->setDateNaissance($faker->dateTimeInInterval());

            $manager->persist($user);
        }


        $manager->flush();
    }
}
