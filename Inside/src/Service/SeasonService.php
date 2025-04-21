<?php

namespace App\Service;

use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use App\Enums\Season;

class SeasonService
{
    public function __construct(private RecipeRepository $recipeRepository, private IngredientRepository $ingredientRepository)
    {

    }

    public function getRecipeSeason(): array
    {
        $year = (int) date('Y');
        $seasons=[];
        foreach(Season::cases() as $season){
            $seasons[$season->value] = $season->getDates($year);
        }
        $currDate = (new \DateTime())->format('Y-m-d');
        $currSeason=null;
        foreach($seasons as $season => $date){
            if($currDate>=$date['start'] && $currDate <= $date['end']){
                $currSeason=$season;
            }
        }
        $seasonIngredients = $this->ingredientRepository->findSeasonIngredients($currSeason);
        $seasonRecipes=$this->recipeRepository->findSeasonRecipes($seasonIngredients);
        return ['season'=>$currSeason, 'recipes' => $seasonRecipes];
    }
}