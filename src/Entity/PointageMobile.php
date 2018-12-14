<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PointageMobileRepository")
 */
class PointageMobile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPointage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $depart;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometrage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heureDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heureArrivee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $positionParking;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Synchro;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $immatriculation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPointage(): ?int
    {
        return $this->idPointage;
    }

    public function setIdPointage(int $idPointage): self
    {
        $this->idPointage = $idPointage;

        return $this;
    }

    public function getIdTagVoiture(): ?string
    {
        return $this->idTagVoiture;
    }

    public function setIdTagVoiture(string $idTagVoiture): self
    {
        $this->idTagVoiture = $idTagVoiture;

        return $this;
    }

    public function getDepart(): ?bool
    {
        return $this->depart;
    }

    public function setDepart(bool $depart): self
    {
        $this->depart = $depart;

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

    public function getHeureDepart(): ?string
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(string $heureDepart): self
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    public function getHeureArrivee(): ?string
    {
        return $this->heureArrivee;
    }

    public function setHeureArrivee(string $heureArrivee): self
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
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

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getPositionParking(): ?string
    {
        return $this->positionParking;
    }

    public function setPositionParking(string $positionParking): self
    {
        $this->positionParking = $positionParking;

        return $this;
    }

    public function getUtilisateur(): ?string
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(string $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getSynchro(): ?bool
    {
        return $this->Synchro;
    }

    public function setSynchro(bool $Synchro): self
    {
        $this->Synchro = $Synchro;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }
}
