<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CtassRepository")
 */
class Ctass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateLastCT;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNextCT;

    /**
     * @ORM\Column(type="date")
     */
    private $dateStartAss;

    /**
     * @ORM\Column(type="date")
     */
    private $dateStopAss;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Voiture", cascade={"persist", "remove"})
     */
    private $voiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLastCT(): ?\DateTimeInterface
    {
        return $this->dateLastCT;
    }

    public function setDateLastCT(\DateTimeInterface $dateLastCT): self
    {
        $this->dateLastCT = $dateLastCT;

        return $this;
    }

    public function getDateNextCT(): ?\DateTimeInterface
    {
        return $this->dateNextCT;
    }

    public function setDateNextCT(\DateTimeInterface $dateNextCT): self
    {
        $this->dateNextCT = $dateNextCT;

        return $this;
    }

    public function getDateStartAss(): ?\DateTimeInterface
    {
        return $this->dateStartAss;
    }

    public function setDateStartAss(\DateTimeInterface $dateStartAss): self
    {
        $this->dateStartAss = $dateStartAss;

        return $this;
    }

    public function getDateStopAss(): ?\DateTimeInterface
    {
        return $this->dateStopAss;
    }

    public function setDateStopAss(\DateTimeInterface $dateStopAss): self
    {
        $this->dateStopAss = $dateStopAss;

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
}
