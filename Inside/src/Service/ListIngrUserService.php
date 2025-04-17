<?php

namespace App\Service;

use App\Entity\User;

class ListIngrUserService
{

    public function getListIngredientsId(User $user) : array{

        $ingredients = $user->getListIngredient()  ;
        $ingredientsId = [];
        if($ingredients != null){

        }

        foreach ($ingredients as $ingredient){
            $id= $ingredient->getId();
            $ingredientsId[] = $id;

        }

        return $ingredientsId;
    }

    public function ingredientsFilter(array $ingredientsFromRepo, array $alreadyInPlacard): array
    {
        $filteredIngredients = [];

        foreach ($ingredientsFromRepo as $ingredient) {
            if (!in_array($ingredient->getId(), $alreadyInPlacard)) {
                $filteredIngredients[] = $ingredient;
            }
        }

        return $filteredIngredients;
    }



}