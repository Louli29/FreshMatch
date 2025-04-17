<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Enums\Diet;

class RecipeFilter
{
    public function filter(array $recipes, array $selectedIngredients, array $excludedAllergies,Diet $requiredDiet, array $pantryIngredients, Score $score ): array{
        $filteredRecipes = [];

        foreach ($recipes as $recipe) {
            $allergies = $this->getAllergy($recipe);

            if (!empty(array_intersect($allergies, $excludedAllergies))) {
                continue;
            }

            if ($requiredDiet !== null) {
                if ($recipe->getDiet() === null || $recipe->getDiet() !== $requiredDiet) {
                    continue;
                }
            }

            $score = $score->getScore($recipe, $selectedIngredients, $pantryIngredients);

            if ($score >= 33) {
                $filteredRecipes[] = [
                    'recipe' => $recipe,
                    'score' => round($score) . '% de correspondance'
                ];
            }
        }
        return $filteredRecipes ;
    }

    public function  getAllergy(Recipe $recipe): array
    {

        $allergies = $recipe->getAllergys() ??[];
        $allergiesName =[];

        foreach ($allergies as $allergy) {
            $name = $allergy->name;
            $allergiesName[] = $name;
        }
        return $allergiesName;
    }
}