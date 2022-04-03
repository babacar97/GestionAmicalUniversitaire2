<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BudgetRepository::class)
 */
class Budget
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
    private $montant;


    /**
     * @ORM\OneToMany(targetEntity=Budgetmoinsdepense::class, mappedBy="budget")
     */
    private $budgetmoinsdepense;

    /**
     * @ORM\OneToMany(targetEntity=Depense::class, mappedBy="budget")
     */
    private $depense;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function __construct()
    {
        $this->budgetmoinsdepense = new ArrayCollection();
        $this->depense = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }



    /**
     * @return Collection<int, budgetmoinsdepense>
     */
    public function getBudgetmoinsdepense(): Collection
    {
        return $this->budgetmoinsdepense;
    }

    public function addBudgetmoinsdepense(budgetmoinsdepense $budgetmoinsdepense): self
    {
        if (!$this->budgetmoinsdepense->contains($budgetmoinsdepense)) {
            $this->budgetmoinsdepense[] = $budgetmoinsdepense;
            $budgetmoinsdepense->setBudget($this);
        }

        return $this;
    }

    public function removeBudgetmoinsdepense(budgetmoinsdepense $budgetmoinsdepense): self
    {
        if ($this->budgetmoinsdepense->removeElement($budgetmoinsdepense)) {
            // set the owning side to null (unless already changed)
            if ($budgetmoinsdepense->getBudget() === $this) {
                $budgetmoinsdepense->setBudget(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, depense>
     */
    public function getDepense(): Collection
    {
        return $this->depense;
    }

    public function addDepense(depense $depense): self
    {
        if (!$this->depense->contains($depense)) {
            $this->depense[] = $depense;
            $depense->setBudget($this);
        }

        return $this;
    }

    public function removeDepense(depense $depense): self
    {
        if ($this->depense->removeElement($depense)) {
            // set the owning side to null (unless already changed)
            if ($depense->getBudget() === $this) {
                $depense->setBudget(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
