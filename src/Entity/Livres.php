<?php

namespace App\Entity;

use App\Repository\LivresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivresRepository::class)]
class Livres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[ORM\Column]
    private ?int $annee_publication = null;

    #[ORM\Column(length: 255)]
    private ?string $maison_edition = null;

    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[ORM\Column(type: Types::BLOB)]
    private $image = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column]
    private ?bool $disponibilite = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getAnneePublication(): ?int
    {
        return $this->annee_publication;
    }

    public function setAnneePublication(int $annee_publication): static
    {
        $this->annee_publication = $annee_publication;

        return $this;
    }

    public function getMaisonEdition(): ?string
    {
        return $this->maison_edition;
    }

    public function setMaisonEdition(string $maison_edition): static
    {
        $this->maison_edition = $maison_edition;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

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

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}
