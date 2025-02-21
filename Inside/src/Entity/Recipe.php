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
    private ?int $duree = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $etape = null;

    #[ORM\Column]
    private ?int $nbPersonne = null;

    /**
     * @var Collection<int, IngredientRecipe>
     */
    #[ORM\ManyToMany(targetEntity: IngredientRecipe::class, inversedBy: 'recette')]
    private Collection $ingredientRecette;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: Allergy::class)]
    private ?array $allergies = null;

    #[ORM\Column(nullable: true, enumType: Diet::class)]
    private ?Diet $regimeAlimentaire = null;

    public function __construct()
    {
        $this->ingredientRecette = new ArrayCollection();
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

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEtape(): ?string
    {
        return $this->etape;
    }

    public function setEtape(string $etape): static
    {
        $this->etape = $etape;

        return $this;
    }

    public function getNbPersonne(): ?int
    {
        return $this->nbPersonne;
    }

    public function setNbPersonne(int $nbPersonne): static
    {
        $this->nbPersonne = $nbPersonne;

        return $this;
    }

    /**
     * @return Collection<int, IngredientRecipe>
     */
    public function getIngredientRecette(): Collection
    {
        return $this->ingredientRecette;
    }

    public function addIngredientRecette(IngredientRecipe $ingredientRecette): static
    {
        if (!$this->ingredientRecette->contains($ingredientRecette)) {
            $this->ingredientRecette->add($ingredientRecette);
        }

        return $this;
    }

    public function removeIngredientRecette(IngredientRecipe $ingredientRecette): static
    {
        $this->ingredientRecette->removeElement($ingredientRecette);

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Allergy[]|null
     */
    public function getAllergies(): ?array
    {
        return $this->allergies;
    }

    public function setAllergies(?array $allergies): static
    {
        $this->allergies = $allergies;

        return $this;
    }

    public function getRegimeAlimentaire(): ?Diet
    {
        return $this->regimeAlimentaire;
    }

    public function setRegimeAlimentaire(?Diet $regimeAlimentaire): static
    {
        $this->regimeAlimentaire = $regimeAlimentaire;

        return $this;
    }
}
