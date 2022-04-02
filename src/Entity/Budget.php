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
     * @ORM\ManyToOne(targetEntity=Depense::class, inversedBy="Budget")
     */
    private $depense;

    /**
     * @ORM\OneToMany(targetEntity=budgetmoinsdepense::class, mappedBy="budget")
     */
    private $budgetmoinsdepense;

    public function __construct()
    {
        $this->budgetmoinsdepense = new ArrayCollection();
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

    public function getDepense(): ?Depense
    {
        return $this->depense;
    }

    public function setDepense(?Depense $depense): self
    {
        $this->depense = $depense;

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
}
