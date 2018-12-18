<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 */
class Voiture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Numero;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="voitures")
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs", inversedBy="voitures")
     */
    private $responsable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="voiture")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pointage", mappedBy="voiture")
     */
    private $pointages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emplacement;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometrage;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->pointages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->Numero;
    }

    public function setNumero(string $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function __toString()
    {
        return ''.$this->getNumero().' - '.$this->getLibelle();
    }

    public function getResponsable(): ?Utilisateurs
    {
        return $this->responsable;
    }

    public function setResponsable(?Utilisateurs $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setVoiture($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getVoiture() === $this) {
                $reservation->setVoiture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pointage[]
     */
    public function getPointages(): Collection
    {
        return $this->pointages;
    }

    public function addPointage(Pointage $pointage): self
    {
        if (!$this->pointages->contains($pointage)) {
            $this->pointages[] = $pointage;
            $pointage->setVoiture($this);
        }

        return $this;
    }

    public function removePointage(Pointage $pointage): self
    {
        if ($this->pointages->contains($pointage)) {
            $this->pointages->removeElement($pointage);
            // set the owning side to null (unless already changed)
            if ($pointage->getVoiture() === $this) {
                $pointage->setVoiture(null);
            }
        }

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

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

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }
}
