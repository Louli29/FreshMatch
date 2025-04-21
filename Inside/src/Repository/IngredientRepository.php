<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\User;


use App\Enums\TypeIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingredient>
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }
    
    public function findSeasonIngredients($saison)
    {
        return $this->createQueryBuilder('i')
            ->where('i.season LIKE :saison')
            ->setParameter('saison', '%'.$saison.'%' )
            ->getQuery()
            ->getResult();
    }

    public function findByTypeIngredient(string $type): array
    {
        $typeEnum = TypeIngredient::tryFrom($type);
        if (!$typeEnum) {
            throw new \InvalidArgumentException("Type d'ingrédient invalide : $type");
        }

        return $this->createQueryBuilder('i')
            ->where('i.typeIngredient = :type')
            ->setParameter('type', $typeEnum)
            ->getQuery()
            ->getResult();
    }

}
