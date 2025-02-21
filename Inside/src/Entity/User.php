<?php

namespace App\Entity;

use App\Enums\Allergy;;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enums\Diet;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?ListIngrUser $listIngrUser = null;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\OneToMany(targetEntity: Recipe::class, mappedBy: 'user')]
    private Collection $recipe;



    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: Allergy::class)]
    private ?array $allergy = null;

    #[ORM\Column(nullable: true, enumType: Diet::class)]
    private ?Diet $diet = null;

    public function __construct()
    {
        $this->recipe = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $nom): static
    {
        $this->name = $nom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $motDePasse): static
    {
        $this->password = $motDePasse;

        return $this;
    }

    public function getListIngrUser(): ?ListIngrUser
    {
        return $this->listIngrUser;
    }

    public function setListIngrUser(ListIngrUser $listIngrUser): static
    {
        // set the owning side of the relation if necessary
        if ($listIngrUser->getUser() !== $this) {
            $listIngrUser->setUser($this);
        }

        $this->listIngrUser = $listIngrUser;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipe(): Collection
    {
        return $this->recipe;
    }

    public function addRecette(Recipe $recipe): static
    {
        if (!$this->recipe->contains($recipe)) {
            $this->recipe->add($recipe);
            $recipe->setUser($this);
        }

        return $this;
    }

    public function removeRecette(Recipe $recipe): static
    {
        if ($this->recipe->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getUser() === $this) {
                $recipe->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Allergy[]|null
     */
    public function getAllergy(): ?array
    {
        return $this->allergy;
    }

    public function setAllergy(?array $allergie): static
    {
        $this->allergy = $allergie;

        return $this;
    }

    public function getDiet(): ?Diet
    {
        return $this->diet;
    }

    public function setRegimeAlimentaire(?Diet $regimeAlimentaire): static
    {
        $this->diet = $regimeAlimentaire;

        return $this;
    }
}
