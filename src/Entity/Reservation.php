<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voiture", inversedBy="reservations")
     */
    private $voiture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs", inversedBy="reservations")
     */
    private $personne;

    /**
     * @ORM\Column(type="datetime")
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fin;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pointage", mappedBy="reservation", cascade={"persist", "remove"})
     */
    private $pointage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPersonne(): ?Utilisateurs
    {
        return $this->personne;
    }

    public function setPersonne(?Utilisateurs $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function __toString()
    {
        return 'Reservation n°'.$this->getId();
    }

    public function getPointage(): ?Pointage
    {
        return $this->pointage;
    }

    public function setPointage(?Pointage $pointage): self
    {
        $this->pointage = $pointage;

        // set (or unset) the owning side of the relation if necessary
        $newReservation = $pointage === null ? null : $this;
        if ($newReservation !== $pointage->getReservation()) {
            $pointage->setReservation($newReservation);
        }

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
