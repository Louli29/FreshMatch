<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class RecipeSearchService
{
    public function __construct(private EntityManagerInterface $em)
    {

    }

    public function findRecipesByIngredientNames(array $ingredientNames): array
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('r')
            ->from('App\Entity\Recipe', 'r')
            ->join('r.ingredientRecipe', 'ir')
            ->join('ir.ingredient', 'i')
            ->where($qb->expr()->in('i.name', ':names'))
            ->setParameter('names', $ingredientNames)
            ->groupBy('r.id');
        return $qb->getQuery()->getResult();
    }

}