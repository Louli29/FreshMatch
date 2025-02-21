<?php

namespace App\Entity;

use App\Enums\TypeIngredient;
use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(enumType: TypeIngredient::class)]
    private ?TypeIngredient $typeIngredient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $nom): static
    {
        $this->name = $nom;

        return $this;
    }

    public function getTypeIngredient(): ?TypeIngredient
    {
        return $this->typeIngredient;
    }

    public function setTypeIngredient(TypeIngredient $typeIngredient): static
    {
        $this->typeIngredient = $typeIngredient;

        return $this;
    }
}
