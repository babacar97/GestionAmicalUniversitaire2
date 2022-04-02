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
}
