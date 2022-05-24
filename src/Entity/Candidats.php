<?php

namespace App\Entity;

use App\Repository\CandidatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatsRepository::class)
 */
class Candidats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $liste;

    /**
     * @ORM\ManyToOne(targetEntity=Campagne::class, inversedBy="candidats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCampagne;

    /**
     * @ORM\Column(type="text")
     */
    private $programmes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?user
    {
        return $this->idUser;
    }

    public function setIdUser(user $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getListe(): ?string
    {
        return $this->liste;
    }

    public function setListe(string $liste): self
    {
        $this->liste = $liste;

        return $this;
    }

    public function getIdCampagne(): ?campagne
    {
        return $this->idCampagne;
    }

    public function setIdCampagne(?campagne $idCampagne): self
    {
        $this->idCampagne = $idCampagne;

        return $this;
    }

    public function getProgrammes(): ?string
    {
        return $this->programmes;
    }

    public function setProgrammes(string $programmes): self
    {
        $this->programmes = $programmes;

        return $this;
    }
}
