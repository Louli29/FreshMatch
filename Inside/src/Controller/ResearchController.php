<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\User;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use App\Service\Score;
use App\Service\UserPreferences;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResearchController extends AbstractController

{

    #[Route('/research', name: 'recipe_research', methods: ['GET', 'POST'])]
    public function index(Request $request, RecipeRepository $recipeRepository,  Score $score, UserPreferences $preferences): Response
    {
        $ingredientString = $request->query->get('ingredients', '');
        $selectedIngredients = $ingredientString ? explode(',', $ingredientString) : [];
        $selectedIngredients = array_map('trim', $selectedIngredients);

        $user = $this->getUser();
        $pantryIngredients = [];
        $excludedAllergies = [];
        $requiredDiet = null;

        if ($user instanceof \App\Entity\User && $user->getListIngredient()) {
            $pantryIngredients = $preferences->getPantry($user);
            $excludedAllergies = $preferences->getAllergy($user);
            $requiredDiet = $preferences->getDiets($user);
        }


        $recipes = [];
        if (!empty($selectedIngredients) || !empty($pantryIngredients)) {
            $recipes = $recipeRepository->findByIngredients(array_merge($selectedIngredients, $pantryIngredients));
        }

        $filteredRecipes = [];
        foreach ($recipes as $recipe) {

            $allergies = $recipe->getAllergys();
            $recipeAllergies = is_array($allergies)
                ? array_map(fn($allergy) => $allergy->name, $allergies)
                : [];


            if (!empty(array_intersect($recipeAllergies, $excludedAllergies))) {
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