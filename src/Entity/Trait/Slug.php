<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait Slug
{
    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }
}