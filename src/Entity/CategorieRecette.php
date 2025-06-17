<?php

namespace App\Entity;

use App\Repository\CategorieRecetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRecetteRepository::class)]
class CategorieRecette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recette = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getRecette(): ?string
    {
        return $this->recette;
    }

    public function setRecette(?string $recette): static
    {
        $this->recette = $recette;

        return $this;
    }
}
