<?php

namespace App\Service;

use App\Entity\Recipe;

class Score{

    public function getScore(Recipe $recipe, Array $pantryIngredients, Array $selectedIngredients) : float{
        $recipeIngredients =  $recipe->getIngredientRecipe();
        $arrayNames = [];

        foreach ($recipeIngredients as $recipeIngredient) {
            $ingredient = $recipeIngredient->getIngredient();
            $name = $ingredient->getName();
            $arrayNames[] = $name;
        }

        $ingredientsChosen = array_merge($selectedIngredients, $pantryIngredients);
        $matchingIngredients = [];
        foreach ($ingredientsChosen as $ingredient) {
            if (in_array($ingredient, $arrayNames)) {
                $matchingIngredients[] = $ingredient;
            }
        }

        return (count($matchingIngredients) / count($recipeIngredients)) * 100;
    }
}