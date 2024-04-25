<?php

namespace App\Entity;

use App\Repository\EquipementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementsRepository::class)]
class Equipements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $nom = null;

    /**
     * @var Collection<int, Salles>
     */
    #[ORM\ManyToMany(targetEntity: Salles::class, mappedBy: 'equipement')]
    private Collection $salles; // Ajout du champ pour stocker le nom de l'équipement

    public function __construct()
    {
        $this->salles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Salles>
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    public function addSalle(Salles $salle): static
    {
        if (!$this->salles->contains($salle)) {
            $this->salles->add($salle);
            $salle->addEquipement($this);
        }

        return $this;
    }

    public function removeSalle(Salles $salle): static
    {
        if ($this->salles->removeElement($salle)) {
            $salle->removeEquipement($this);
        }

        return $this;
    }
}

