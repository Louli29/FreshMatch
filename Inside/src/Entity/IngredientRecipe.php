<?php

namespace App\Entity;

use App\Repository\IngredientRecipeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRecipeRepository::class)]
class IngredientRecipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

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
    #[ORM\ManyToOne(targetEntity: Recipe::class, inversedBy: 'ingredientRecipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe;
    public function __construct(?Recipe $recipe = null)
    {
        $this->recipe = $recipe;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantite): static
    {
        $this->quantity = $quantite;

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

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }
}
