<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\User;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResearchController extends AbstractController

{

    #[Route('/research', name: 'recipe_research', methods: ['GET', 'POST'])]
    public function index(Request $request, RecipeRepository $recipeRepository, IngredientRepository $ingredientRepository): Response
    {
        $ingredientString = $request->query->get('ingredients', '');
        $selectedIngredients = $ingredientString ? explode(',', $ingredientString) : [];
        $selectedIngredients = array_map('trim', $selectedIngredients);

        $user = $this->getUser();
        $pantryIngredients = [];
        $excludedAllergies = [];
        $requiredDiet = null;

        // Si l'utilisateur est connecté
        if ($user instanceof \App\Entity\User) {
            // Récupération des allergies de l'utilisateur (converties en chaînes de caractères)
            $excludedAllergies = array_map(fn($allergy) => $allergy->name, $user->getAllergy() ?? []);


            $requiredDiet = $user->getDiet();

        }


        if ($user instanceof \App\Entity\User && $user->getListIngredient()) {
            $pantryIngredients = $user->getListIngredient()->getIngredient()->map(fn($ingredient) => $ingredient->getName())->toArray();
        }


        $recipes = [];
        if (!empty($selectedIngredients) || !empty($pantryIngredients)) {
            $recipes = $recipeRepository->findByIngredients(array_merge($selectedIngredients, $pantryIngredients));
        }

        $filteredRecipes = [];
        foreach ($recipes as $recipe) {

            $recipeIngredients = $recipe->getIngredientRecipe()->map(fn($ir) => $ir->getIngredient()->getName())->toArray();

            $recipeAllergies = array_map(fn($allergy) => $allergy->name, $recipe->getAllergys() ?? []);
            if (!empty(array_intersect($recipeAllergies, $excludedAllergies))) {
                continue;
            }

            if($requiredDiet !== null ){
                if ( $recipe->getDiet() !== null ) {
                    continue;
                }
                else if( $recipe->getDiet() !== $requiredDiet){
                    continue;
                }
            }


            $matchingIngredients = array_intersect($recipeIngredients, array_merge($selectedIngredients, $pantryIngredients));
            $score = (count($matchingIngredients) / count($recipeIngredients)) * 100;


            if ($score >= 33) {
                $filteredRecipes[] = [
                    'recipe' => $recipe,
                    'score' => round($score) . '% de correspondance'
                ];
            }
        }



        return $this->render('research/index.html.twig', [
            'recipes' => $filteredRecipes,
        ]);
    }



    #[Route('/autocomplete/ingredients', name: 'autocomplete_ingredients')]
    public function autocomplete(Request $request, IngredientRepository $ingredientRepository): JsonResponse
    {
        $term = $request->query->get('term');

        $results = $ingredientRepository->createQueryBuilder('i')
            ->where('i.name LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $ingredients = array_map(fn($ingredient) => ['name' => $ingredient->getName()], $results);

        return new JsonResponse($ingredients);
    }
}