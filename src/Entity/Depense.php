<?php

namespace App\Entity;

use App\Repository\DepenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepenseRepository::class)
 */
class Depense
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commentaires;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $justificatif;

    /**
     * @ORM\OneToMany(targetEntity=Budgetmoinsdepense::class, mappedBy="depense")
     */
    private $budgetmoinsdepense;

    /**
     * @ORM\ManyToOne(targetEntity=Budget::class, inversedBy="depense")
     */
    private $budget;

    public function __construct()
    {
        $this->Budget = new ArrayCollection();
        $this->budgetmoinsdepense = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Budget>
     */
    public function getBudget(): Collection
    {
        return $this->Budget;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(string $commentaires): self
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getJustificatif(): ?string
    {
        return $this->justificatif;
    }

    public function setJustificatif(string $justificatif): self
    {
        $this->justificatif = $justificatif;

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
            $budgetmoinsdepense->setDepense($this);
        }

        return $this;
    }

    public function removeBudgetmoinsdepense(budgetmoinsdepense $budgetmoinsdepense): self
    {
        if ($this->budgetmoinsdepense->removeElement($budgetmoinsdepense)) {
            // set the owning side to null (unless already changed)
            if ($budgetmoinsdepense->getDepense() === $this) {
                $budgetmoinsdepense->setDepense(null);
            }
        }

        return $this;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }
}
