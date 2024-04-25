<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SallesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: SallesRepository::class)]
class Salles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $capacite = null;

    #[ORM\Column]
    private ?int $emplacement = null;

    #[ORM\Column]
    private ?bool $disponibilite = null;

    /**
     * @var Collection<int, Rental>
     */
    #[ORM\OneToMany(targetEntity: Rental::class, mappedBy: 'room')]
    private Collection $rentals;
    
    /**
     * @var Collection<int, Equipements>
     */
    #[ORM\ManyToMany(targetEntity: Equipements::class, inversedBy: 'salles')]
    private Collection $equipement;
    
    public function __construct()
    {
        $this->rentals = new ArrayCollection();
        $this->equipement = new ArrayCollection();
    }
    
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getNom(): ?string
    {
        return $this->nom;
    }
    
    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        
        return $this;
    }
    
    public function getCapacite(): ?string
    {
        return $this->capacite;
    }
    
    public function setCapacite(string $capacite): static
    {
        $this->capacite = $capacite;
        
        return $this;
    }
    
    public function getEmplacement(): ?int
    {
        return $this->emplacement;
    }

    public function setEmplacement(int $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * @return Collection<int, Rental>
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Rental $rental): static
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals->add($rental);
            $rental->setRoom($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): static
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getRoom() === $this) {
                $rental->setRoom(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Equipements>
     */
    public function getEquipement(): Collection
    {
        return $this->equipement;
    }

    public function addEquipement(Equipements $equipement): static
    {
        if (!$this->equipement->contains($equipement)) {
            $this->equipement->add($equipement);
        }

        return $this;
    }

    public function removeEquipement(Equipements $equipement): static
    {
        $this->equipement->removeElement($equipement);

        return $this;
    }

}
