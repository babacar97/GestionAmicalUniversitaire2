<?php

namespace App\DataFixtures;

use App\Entity\Budget;
use App\Entity\Depense;
use Faker\Factory;
use App\Entity\User;
use App\Repository\BudgetRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // public function __construct(UserPasswordHasherInterface $hasher)
    // {
    //     $this->hasher = $hasher;
    // }

    private $budgetRepository;

    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("fr_FR");

        for ($i = 0; $i < 100; $i++) {
            // $user = new User();
            // $user->setEmail($faker->email())
            //     ->setPassword($faker->password())
            //     ->setNom($faker->firstName())
            //     ->setPrenom($faker->lastName())
            //     ->setAdresse($faker->address())
            //     ->setNumeroTelephone($faker->e164PhoneNumber())
            //     ->setLieuNaissance($faker->company())
            //     ->setNumeroCarteIdentite($faker->isbn13())
            //     ->setNumeroCarteEtudiant($faker->isbn13())
            //     ->setFaculte($faker->city())
            //     ->setNiveauEtude($faker->city())
            //     ->setCodification($faker->boolean())
            //     ->setImage($faker->imageUrl())
            //     ->setDateNaissance($faker->dateTimeInInterval());

            // $budget = new Budget();
            // $budget->setMontant($faker->ean8())
            //     ->setDate($faker->dateTimeInInterval())
            //     ->setNomBudget($faker->name());

            $depense = new Depense();

            $idbuget = $this->budgetRepository->findOneById('id');
            // $idbudget = Budget::lists('id')->all();
            $depense->setAuteur($faker->name())
                ->setCommentaires($faker->text())
                ->setDate($faker->dateTimeInInterval())
                ->setMontant($faker->ean8())
                ->setType($faker->jobTitle())
                ->setBudget($faker->randomElement($idbuget))
                ->setJustificatif($faker->domainWord());

            $manager->persist($depense);
        }


        $manager->flush();
    }
}
