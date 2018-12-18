<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PointageRepository")
 */
class Pointage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sortie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $entree;

    /**
     * @ORM\Column(type="integer")
     */
    private $kiloAvant;

    /**
     * @ORM\Column(type="integer")
     */
    private $kiloApres;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $obsAvant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $obsApres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emplacement;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Reservation", inversedBy="pointage", cascade={"persist", "remove"})
     */
    private $reservation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs", inversedBy="pointages")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voiture", inversedBy="pointages")
     */
    private $voiture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destination;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSortie(): ?\DateTimeInterface
    {
        return $this->sortie;
    }

    public function setSortie(\DateTimeInterface $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getEntree(): ?\DateTimeInterface
    {
        return $this->entree;
    }

    public function setEntree(\DateTimeInterface $entree): self
    {
        $this->entree = $entree;

        return $this;
    }

    public function getKiloAvant(): ?int
    {
        return $this->kiloAvant;
    }

    public function setKiloAvant(int $kiloAvant): self
    {
        $this->kiloAvant = $kiloAvant;

        return $this;
    }

    public function getKiloApres(): ?int
    {
        return $this->kiloApres;
    }

    public function setKiloApres(int $kiloApres): self
    {
        $this->kiloApres = $kiloApres;

        return $this;
    }

    public function getObsAvant(): ?string
    {
        return $this->obsAvant;
    }

    public function setObsAvant(?string $obsAvant): self
    {
        $this->obsAvant = $obsAvant;

        return $this;
    }

    public function getObsApres(): ?string
    {
        return $this->obsApres;
    }

    public function setObsApres(?string $obsApres): self
    {
        $this->obsApres = $obsApres;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateurs
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateurs $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function __toString()
    {
        return 'Pointage n°'.$this->getId();
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }
}
