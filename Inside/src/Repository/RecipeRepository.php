<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function findSeasonRecipes(array $ingredientsDeSaison): array
    {
        return $this->createQueryBuilder('r')
        // Jointure avec IngredientRecipe
        ->innerJoin('r.ingredientRecipe', 'ir')
        // Jointure avec Ingredient
        ->innerJoin('ir.ingredient', 'i')
        // Filtrer par les ingrédients de saison
        ->andWhere('i.id IN (:ingredients)')
        ->setParameter('ingredients', array_map(function($ingredient) {
            return $ingredient->getId();
        }, $ingredientsDeSaison))
        // Retourner les résultats sous forme de tableau d'objets Recipe
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Recipe[] Returns an array of Recipe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recipe
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
