<?php

namespace App\Entity;

use App\Repository\BudgetmoinsdepenseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BudgetmoinsdepenseRepository::class)
 */
class Budgetmoinsdepense
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $restantBudget;

    /**
     * @ORM\ManyToOne(targetEntity=Depense::class, inversedBy="Budgetmoinsdepense")
     */
    private $depense;

    /**
     * @ORM\ManyToOne(targetEntity=Budget::class, inversedBy="Budgetmoinsdepense")
     */
    private $budget;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRestantBudget(): ?int
    {
        return $this->restantBudget;
    }

    public function setRestantBudget(int $restantBudget): self
    {
        $this->restantBudget = $restantBudget;

        return $this;
    }

    public function getDepense(): ?Depense
    {
        return $this->depense;
    }

    public function setDepense(?Depense $depense): self
    {
        $this->depense = $depense;

        return $this;
    }

    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }
}
