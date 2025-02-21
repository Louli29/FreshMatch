<?php

namespace App\Entity;

use  App\Enums\Allergy;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enums\Diet;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $time = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $step = null;

    #[ORM\Column]
    private ?int $nbPerson = null;

    /**
     * @var Collection<int, IngredientRecipe>
     */
    #[ORM\ManyToMany(targetEntity: IngredientRecipe::class, inversedBy: 'Recipe')]
    private Collection $ingredientRecipe;

    #[ORM\ManyToOne(inversedBy: 'Recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: Allergy::class)]
    private ?array $allergys = null;

    #[ORM\Column(nullable: true, enumType: Diet::class)]
    private ?Diet $diet = null;

    #[ORM\Column(type: 'string')]
    private string $imageLink;

    public function getImageLink(): string
    {
        return $this->imageLink;
    }

    public function setImageLink(string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function __construct()
    {
        $this->ingredientRecipe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStep(): ?string
    {
        return $this->step;
    }

    public function setStep(string $step): static
    {
        $this->step = $step;

        return $this;
    }

    public function getNbPerson(): ?int
    {
        return $this->nbPerson;
    }

    public function setNbPerson(int $nbPerson): static
    {
        $this->nbPerson = $nbPerson;

        return $this;
    }

    /**
     * @return Collection<int, IngredientRecipe>
     */
    public function getIngredientRecipe(): Collection
    {
        return $this->ingredientRecipe;
    }

    public function addIngredientRecipe(IngredientRecipe $ingredientRecipe): static
    {
        if (!$this->ingredientRecipe->contains($ingredientRecipe)) {
            $this->ingredientRecipe->add($ingredientRecipe);
        }

        return $this;
    }

    public function removeIngredientRecipe(IngredientRecipe $ingredientRecipe): static
    {
        $this->ingredientRecipe->removeElement($ingredientRecipe);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Allergy[]|null
     */
    public function getAllergys(): ?array
    {
        return $this->allergys;
    }

    public function setAllergys(?array $allergys): static
    {
        $this->allergys = $allergys;

        return $this;
    }

    public function getDiet(): ?Diet
    {
        return $this->diet;
    }

    public function setDiet(?Diet $diet): static
    {
        $this->diet = $diet;

        return $this;
    }
}
