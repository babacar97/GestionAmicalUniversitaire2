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
        $user = new User();
        $faker = Factory::create("fr_FR");

        for ($i = 0; $i < 100; $i++) {

            $password = $this->hasher->hashPassword($user, 'pass_1234');

            $user->setEmail("test@user.com")
                ->setPassword($password)
                ->setNom($faker->Nom)
                ->setPrenom($faker->prenom)
                ->setAdresse($faker->adresse)
                ->setNumeroTelephone($faker->numeroTelephone)
                ->setDateNaissance($faker->dateNaissance)
                ->setLieuNaissance($faker->lieuNaissance)
                ->setNumeroCarteIdentite($faker->numeroCarteIdentite)
                ->setNumeroCarteEtudiant($faker->numeroCarteEtudiant)
                ->setFaculte($faker->faculte)
                ->setNiveauEtude($faker->niveauEtude)
                ->setCodification($faker->codification)
                ->setImage($faker->image);

            // $product = new Product();
            // $manager->persist($product);
        }


        $manager->flush();
    }
}
