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

    public function findSeasonRecipes(array $seasonIngr): array
    {
        return $this->createQueryBuilder('r')

        ->innerJoin('r.ingredientRecipe', 'ir')

        ->innerJoin('ir.ingredient', 'i')

        ->andWhere('i.id IN (:ingredients)')
        ->setParameter('ingredients', array_map(function($ingredient) {
            return $ingredient->getId();
        }, $seasonIngr))

        ->getQuery()
        ->getResult();
    }
    public function findByIngredients(array $ingredients): array
    {
        $allIngredients = $this->findEquivalentIngredients($ingredients);

        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.ingredientRecipe', 'ir')
            ->innerJoin('ir.ingredient', 'i')
            ->where('i.name IN (:ingredients) OR (ir.remplacable = true AND i.name IN (:equivalentIngredients))')
            ->setParameter('ingredients', $ingredients)
            ->setParameter('equivalentIngredients', $allIngredients);

        return $qb->getQuery()->getResult();
    }



    public function findEquivalentIngredients(array $ingredients): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();


        $qb->select('DISTINCT i.typeIngredient')
            ->from('App\Entity\Ingredient', 'i')
            ->where('i.name IN (:ingredients)')
            ->setParameter('ingredients', $ingredients);

        $typeIngredients = array_column($qb->getQuery()->getResult(), 'typeIngredient');

        if (empty($typeIngredients)) {
            return $ingredients;
        }


        $qb2 = $this->getEntityManager()->createQueryBuilder();
        $qb2->select('i.name')
            ->from('App\Entity\Ingredient', 'i')
            ->where('i.typeIngredient IN (:types)')
            ->setParameter('types', $typeIngredients);

        $equivalentIngredients = array_column($qb2->getQuery()->getResult(), 'name');

        return array_merge($ingredients, $equivalentIngredients);
    }
}
