<?php

namespace App\Controller;

use App\Entity\IngredientRecipe;
use App\Enums\Season;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    public function __construct(private RecipeRepository $recipeRepository, private IngredientRepository $ingredientRepository)
    {
        
    }

    #[Route('/', name: 'home_page', methods:['GET'])]
    public function index(): Response
    {
        $year = (int) date('Y'); // Permet de récupérer l'année actuelle
        $saisons=[]; // Créer un tableau qui stocke toutes les saisons avec leur date de début et de fin associé
        foreach(Season::cases() as $saison){ // Parcours toute l'énumération Saison
            $saisons[$saison->value] = $saison->getDates($year); // Récupère les dates associées aux saisons
        }
        $dateActuelle = (new \DateTime())->format('Y-m-d');
        $saisonCourant=null;
        foreach($saisons as $saison => $date){
            if($dateActuelle>=$date['start'] && $dateActuelle <= $date['end']){
                $saisonCourant=$saison;
            }  
        }
        $ingredientsDeSaison = $this->ingredientRepository->findSeasonIngredients($saisonCourant);
        $seasonRecipes=$this->recipeRepository->findSeasonRecipes($ingredientsDeSaison);
        return $this->render('home_page/HomePage.html.twig', [
            'saison'=>$saisonCourant, 'recipes' => $seasonRecipes
        ]);
    }
}
