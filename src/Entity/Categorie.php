<?php

namespace App\Entity;

use App\Entity\Recette;
use App\Entity\Categorie;
use App\Entity\Ingredient;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description2 = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\OneToMany(targetEntity: Ingredient::class, mappedBy: 'categorie')]
    private Collection $ingredients;

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\ManyToMany(targetEntity: Recette::class, inversedBy: 'categories')]
    private Collection $recette;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->recette = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    public function setDescription2(?string $description2): static
    {
        $this->description2 = $description2;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setCategorie($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getCategorie() === $this) {
                $ingredient->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recette>
     */
    public function getRecette(): Collection
    {
        return $this->recette;
    }

    public function addRecette(Recette $recette): static
    {
        if (!$this->recette->contains($recette)) {
            $this->recette->add($recette);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        $this->recette->removeElement($recette);

        return $this;
    }
}
