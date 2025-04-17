<?php

namespace App\Service;

use App\Entity\User;

class UserPreferences {

    public function getPantry(User $user): array
    {
        $listIngredients = $user->getListIngredient();
        $ingredients = $listIngredients->getIngredient();
        $pantryIngredients =[];
        foreach ($ingredients as $ingredient) {
            $name = $ingredient->getName();
            $pantryIngredients [] = $name;
        }

        return $pantryIngredients;
    }

    public function  getAllergy(User $user): array
    {

        $allergies = $user->getAllergy() ??[];
        $allergiesName =[];

        foreach ($allergies as $allergy) {
            $name = $allergy->name;
            $allergiesName[] = $name;
        }
        return $allergiesName;
    }

    public function getDiets(User $user): \App\Enums\Diet
    {
        return $user->getDiet();
    }

}