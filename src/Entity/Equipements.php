<?php

namespace App\Entity;

use App\Repository\EquipementsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementsRepository::class)]
class Equipements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Equipements = null;

    #[ORM\Column(length: 255)]
    private ?string $WiFi = null;

    #[ORM\Column(length: 255)]
    private ?string $Projecteur = null;

    #[ORM\Column(length: 255)]
    private ?string $Tableau = null;

    #[ORM\Column(length: 255)]
    private ?string $Prises = null;

    #[ORM\Column(length: 255)]
    private ?string $Television = null;

    #[ORM\Column(length: 255)]
    private ?string $Climatisation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipements(): ?string
    {
        return $this->Equipements;
    }

    public function setEquipements(string $Equipements): static
    {
        $this->Equipements = $Equipements;

        return $this;
    }

    public function getWiFi(): ?string
    {
        return $this->WiFi;
    }

    public function setWiFi(string $WiFi): static
    {
        $this->WiFi = $WiFi;

        return $this;
    }

    public function getProjecteur(): ?string
    {
        return $this->Projecteur;
    }

    public function setProjecteur(string $Projecteur): static
    {
        $this->Projecteur = $Projecteur;

        return $this;
    }

    public function getTableau(): ?string
    {
        return $this->Tableau;
    }

    public function setTableau(string $Tableau): static
    {
        $this->Tableau = $Tableau;

        return $this;
    }

    public function getPrises(): ?string
    {
        return $this->Prises;
    }

    public function setPrises(string $Prises): static
    {
        $this->Prises = $Prises;

        return $this;
    }

    public function getTelevision(): ?string
    {
        return $this->Television;
    }

    public function setTelevision(string $Television): static
    {
        $this->Television = $Television;

        return $this;
    }

    public function getClimatisation(): ?string
    {
        return $this->Climatisation;
    }

    public function setClimatisation(string $Climatisation): static
    {
        $this->Climatisation = $Climatisation;

        return $this;
    }
}
