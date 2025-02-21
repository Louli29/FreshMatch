<?php

namespace App\Entity;

use App\Enums\Allergie;;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enums\RegimeAlimentaire;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?ListIngrUser $listIngrUtilisateur = null;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\OneToMany(targetEntity: Recipe::class, mappedBy: 'utilisateur')]
    private Collection $recettes;



    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: Allergie::class)]
    private ?array $allergie = null;

    #[ORM\Column(nullable: true, enumType: RegimeAlimentaire::class)]
    private ?RegimeAlimentaire $regimeAlimentaire = null;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getListIngrUtilisateur(): ?ListIngrUser
    {
        return $this->listIngrUtilisateur;
    }

    public function setListIngrUtilisateur(ListIngrUser $listIngrUtilisateur): static
    {
        // set the owning side of the relation if necessary
        if ($listIngrUtilisateur->getUtilisateur() !== $this) {
            $listIngrUtilisateur->setUtilisateur($this);
        }

        $this->listIngrUtilisateur = $listIngrUtilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recipe $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRecette(Recipe $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getUtilisateur() === $this) {
                $recette->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Allergie[]|null
     */
    public function getAllergie(): ?array
    {
        return $this->allergie;
    }

    public function setAllergie(?array $allergie): static
    {
        $this->allergie = $allergie;

        return $this;
    }

    public function getRegimeAlimentaire(): ?RegimeAlimentaire
    {
        return $this->regimeAlimentaire;
    }

    public function setRegimeAlimentaire(?RegimeAlimentaire $regimeAlimentaire): static
    {
        $this->regimeAlimentaire = $regimeAlimentaire;

        return $this;
    }
}
