<?php

namespace App\Entity;

use App\Repository\IngredientRecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRecetteRepository::class)]
class IngredientRecipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?bool $remplacable = null;

    #[ORM\Column(length: 50)]
    private ?string $unite = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredient $ingredient = null;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'ingredientRecette')]
    private Collection $recette;

    public function __construct()
    {
        $this->recette = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function isRemplacable(): ?bool
    {
        return $this->remplacable;
    }

    public function setRemplacable(bool $remplacable): static
    {
        $this->remplacable = $remplacable;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): static
    {
        $this->unite = $unite;

        return $this;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecette(): Collection
    {
        return $this->recette;
    }

    public function addRecette(Recipe $recette): static
    {
        if (!$this->recette->contains($recette)) {
            $this->recette->add($recette);
            $recette->addIngredientRecette($this);
        }

        return $this;
    }

    public function removeRecette(Recipe $recette): static
    {
        if ($this->recette->removeElement($recette)) {
            $recette->removeIngredientRecette($this);
        }

        return $this;
    }
}
