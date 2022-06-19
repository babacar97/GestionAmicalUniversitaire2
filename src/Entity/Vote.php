<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoteRepository::class)
 */
class Vote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_vote;

    /**
     * @ORM\OneToOne(targetEntity=Candidats::class, cascade={"persist", "remove"})
     */
    private $id_candidat;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="integer")
     */
    private $codeDeConfirmation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $aVoter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVote(): ?\DateTimeInterface
    {
        return $this->date_vote;
    }

    public function setDateVote(\DateTimeInterface $date_vote = null): self
    {
        $this->date_vote = $date_vote;

        return $this;
    }

    public function getIdCandidat(): ?candidats
    {
        return $this->id_candidat;
    }

    public function setIdCandidat(?candidats $id_candidat = null): self
    {
        $this->id_candidat = $id_candidat;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->id_user;
    }

    public function setIdUser(user $id_user = null): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function __toString()
    {
        return $this->somePropertyOrPlainString;
    }

    public function getCodeDeConfirmation(): ?int
    {
        return $this->codeDeConfirmation;
    }

    public function setCodeDeConfirmation(int $codeDeConfirmation = null): self
    {
        $this->codeDeConfirmation = $codeDeConfirmation;

        return $this;
    }

    public function getAVoter(): ?bool
    {
        return $this->aVoter;
    }

    public function setAVoter(bool $aVoter = null): self
    {
        $this->aVoter = $aVoter;

        return $this;
    }
}
